<?php require_once __DIR__ . "/auth.php"; auth_init(); auth_require_login(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
<?php include "./Navbar.php" ?>

<section class="TitleFAQS">
<h1>Heb jij vragen?</h1>
<p class="Tekst6">Beneden heb je de meeste gestelde vragen van mensen die al beantwoord zijn</p>
</section>

<section class="SectionBodyFAQS">
<section class="Section5">
<div class="faq-item">
    <span class="faq-number">1</span>
    <div class="faq-content">
        <h2>Wat voor creatieve workshops bieden jullie aan?</h2>
        <p>We geven creatieve workshops zoals schilderen (bijv. Bob<br> Ross, Picasso, Van Gogh), Action Painting en het<br> beschilderen van servies of beeldjes.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">2</span>
    <div class="faq-content">
        <h2>Voor wie zijn de workshops?</h2>
        <p>Voor bedrijven die een leuk teamuitje willen. Soms ook voor particulieren.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">3</span>
    <div class="faq-content">
        <h2>Waar worden de workshops gegeven?</h2>
        <p>Op locatie. Bijvoorbeeld bij het bedrijf zelf of in een restaurant.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">4</span>
    <div class="faq-content">
        <h2>Moet je goed kunnen schilderen?</h2>
        <p>Nee, iedereen kan meedoen. Ik help stap voor stap.</p>
    </div>
</div>
</section>

<section class="Section6">
<div class="faq-item">
    <span class="faq-number">5</span>
    <div class="faq-content">
        <h2>Wat is het doel van de workshop?</h2>
        <p>Samen iets creatiefs doen, ontspannen en gezelligheid met collega’s.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">6</span>
    <div class="faq-content">
        <h2>Hoe lang duurt een workshop?</h2>
        <p>Meestal tussen de 2 en 3 uur.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">7</span>
    <div class="faq-content">
        <h2>Hoeveel mensen kunnen meedoen?</h2>
        <p>Dat hangt af van de locatie en de workshop. Dit bespreken we samen.</p>
    </div>
</div>

<div class="faq-item">
    <span class="faq-number">8</span>
    <div class="faq-content">
        <h2>Moeten we zelf materialen meenemen?</h2>
        <p>Nee, alle materialen worden geregeld.</p>
    </div>
</div>
</section>
</section>

<?php include "./Footer.php" ?>
</body>

</html>
