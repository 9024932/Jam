<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reviews</title>
</head>

<body>
    <?php include "./Navbar.php" ?>
<h2 class="h2r">Wat onze klanten zeggen</h2>
    <img class="rewiesp" src="./Afbeeldingen/rewiews.png" alt="">

<section class="reviewsbody">
<img class="man1" src="./Afbeeldingen/man.png" alt="">
<div class="rating">
            <input type="radio" name="rating" id="star5">
            <label for="star5">★</label>

            <input type="radio" name="rating" id="star4">
            <label for="star4">★</label>

            <input type="radio" name="rating" id="star3">
            <label for="star3">★</label>

            <input type="radio" name="rating" id="star2">
            <label for="star2">★</label>

            <input type="radio" name="rating" id="star1">
            <label for="star1">★</label>
        </div>
<textarea class="textarea" name="" id="">
  
</textarea>

<button class="postbtn">Post</button>

</section>

    <?php include "./Footer.php" ?>
</body>

</html>
