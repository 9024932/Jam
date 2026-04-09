<?php
require_once __DIR__ . "/auth.php";
$user = auth_user();
?>
<ul>
  <?php if ($user) { ?>
    <li class="nav-user-li"><span class="nav-user">Hallo, <?php echo htmlspecialchars($user["name"] ?: "Anoniem", ENT_QUOTES, "UTF-8"); ?></span></li>
    <li class="uitlog"><a href="Login.php">Uitloggen</a></li>
  <?php } else { ?>
    <li class="nav-user-li"><a href="Login.php">Inloggen</a></li>
  <?php } ?>
  <li class="nav-spacer" aria-hidden="true"></li>

  <li><a href="index.php">Home</a></li>
  <li><a href="Contact.php">Contact</a></li>
  <li><a href="Overmij.php">Over mij</a></li>
  <li><a href="FAQS.php">FAQS</a></li>
  <li><a href="Reviews.php">Reviews</a></li>
  <li><a class="BookWorkshop" href="BookWorkshop.php">Book Workshop</a></li>
</ul>
