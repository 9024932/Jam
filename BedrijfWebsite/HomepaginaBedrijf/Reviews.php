<?php
require_once __DIR__ . "/auth.php";
auth_init();

$sent = (isset($_GET["sent"]) && $_GET["sent"] === "1");
$error = null;
$reviewsFile = __DIR__ . DIRECTORY_SEPARATOR . "reviews.json";

$reviews = [];
if (is_file($reviewsFile)) {
    $decoded = json_decode((string) file_get_contents($reviewsFile), true);
    if (is_array($decoded)) {
        $reviews = $decoded;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $review = trim($_POST["review"] ?? "");
    $rating = (int) ($_POST["rating"] ?? 0);
    $name = trim($_POST["name"] ?? "");
    $name = preg_replace('/\s+/', ' ', $name ?? "");
    $name = substr($name, 0, 40);

    if ($rating >= 1 && $rating <= 5 && $review !== "") {
        array_unshift($reviews, [
            "rating" => $rating,
            "name" => $name,
            "review" => $review,
            "created_at" => date("c"),
        ]);
        $reviews = array_slice($reviews, 0, 50);

        file_put_contents(
            $reviewsFile,
            json_encode($reviews, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            LOCK_EX
        );

        header("Location: Reviews.php?sent=1");
        exit;
    }

    if ($rating < 1 || $rating > 5) {
        $error = "Kies eerst een rating (sterren).";
    } else {
        $error = "Vul eerst een review in voordat je op Post drukt.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reviews</title>
</head>

<body>
    <?php include "./Navbar.php" ?>
    <?php if ($sent) { ?>
        <div class="flash flash--success" role="status" aria-live="polite">Succesvol verzonden.</div>
    <?php } ?>

    <?php if ($error) { ?>
        <div class="flash flash--error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></div>
    <?php } ?>
<h2 class="h2r">Wat onze klanten zeggen</h2>


<div class="reviews-layout">
    <section class="reviews-list" aria-label="Reviews">
        <?php if (count($reviews) === 0) { ?>
            <p class="reviews-empty">Nog geen reviews. Plaats de eerste review rechts.</p>
        <?php } else { ?>
            <div class="reviews-grid">
                <?php foreach ($reviews as $item) {
                    $itemRating = (int) ($item["rating"] ?? 0);
                    $itemRating = max(1, min(5, $itemRating));
                    $itemName = trim((string) ($item["name"] ?? ""));
                    if ($itemName === "") {
                        $itemName = "Anoniem";
                    }
                    $itemText = (string) ($item["review"] ?? "");
                    $itemDate = (string) ($item["created_at"] ?? "");
                ?>
                    <article class="review-card">
                        <div class="review-card__top">
                            <img class="review-card__avatar" src="./Afbeeldingen/man.png" alt="">
                            <div class="review-card__meta">
                                <div class="review-card__name"><?php echo htmlspecialchars($itemName, ENT_QUOTES, "UTF-8"); ?></div>
                                <div class="review-card__stars" aria-label="<?php echo $itemRating; ?> van 5 sterren">
                                    <?php echo str_repeat("&#9733;", $itemRating) . str_repeat("&#9734;", 5 - $itemRating); ?>
                                </div>
                            </div>
                        </div>
                        <p class="review-card__text"><?php echo nl2br(htmlspecialchars($itemText, ENT_QUOTES, "UTF-8")); ?></p>
                        <?php $itemTs = ($itemDate !== "") ? strtotime($itemDate) : false; ?>
                        <?php if ($itemTs !== false) { ?>
                            <div class="review-card__date"><?php echo htmlspecialchars(date("d-m-Y H:i", $itemTs), ENT_QUOTES, "UTF-8"); ?></div>
                        <?php } ?>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </section>

<form class="reviewsbody" method="post" action="Reviews.php" novalidate>
<img class="man1" src="./Afbeeldingen/man.png" alt="">
<div class="rating">
            <?php $postedRating = (int) ($_POST["rating"] ?? 0); ?>
            <input type="radio" name="rating" id="star5" value="5" required <?php echo ($postedRating === 5) ? "checked" : ""; ?>>
            <label for="star5">★</label>

            <input type="radio" name="rating" id="star4" value="4" <?php echo ($postedRating === 4) ? "checked" : ""; ?>>
            <label for="star4">★</label>

            <input type="radio" name="rating" id="star3" value="3" <?php echo ($postedRating === 3) ? "checked" : ""; ?>>
            <label for="star3">★</label>

            <input type="radio" name="rating" id="star2" value="2" <?php echo ($postedRating === 2) ? "checked" : ""; ?>>
            <label for="star2">★</label>

            <input type="radio" name="rating" id="star1" value="1" <?php echo ($postedRating === 1) ? "checked" : ""; ?>>
            <label for="star1">★</label>
        </div>
<input class="nameinput" type="text" name="name" id="name" placeholder="Naam (optioneel)" value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<textarea class="textarea" name="review" id="review" placeholder="Schrijf hier je review..."><?php echo htmlspecialchars($_POST["review"] ?? "", ENT_QUOTES, "UTF-8"); ?></textarea>

<button class="postbtn" type="submit">Post</button>

</form>

</div>

    <?php include "./Footer.php" ?>
</body>

</html>
