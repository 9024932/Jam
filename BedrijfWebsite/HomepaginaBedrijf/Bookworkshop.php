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
<div class="workshop-container">
<section class="BookworkshopCardBody">
<h1>Book a Workshop</h1>
<p class="BookworkshopText">Ik bied creatieve workshops op locatie. Bij jullie op kantoor, in een restaurant of op een externe plek in de regio Rotterdam.
Je kunt kiezen uit drie duidelijke formats:

<Section class="BookworkshopCard">
<h3>1. Schilder & Ontspan</h3>
<p>Voor teams die samen willen lachen en creëren. Een begeleide schilderworkshop (bijvoorbeeld Bob Ross, Van Gogh, Picasso of Dikke Dames-stijl).Iedereen maakt zijn eigen kunstwerk. Geen ervaring nodig.Resultaat: ontspanning, plezier en een tastbare herinnering om mee naar huis te nemen. </p>
<h3>2. Action Painting Experience</h3>
<p>Voor teams die energie en creativiteit willen loslaten.Vrij, expressief schilderen met kleur, beweging en samenwerking.Perfect voor teambuilding en het doorbreken van patronen.Resultaat: energie, verbinding en verrassende creaties. </p>
<h3>3. Creatief & Tastbaar</h3>
<p>Voor teams die iets blijvends willen maken.Servies, beeldjes of objecten beschilderen in eigen stijl.Ideaal als origineel personeelsuitje.Resultaat: een uniek kunstwerk én een gezellige, ontspannen middag of avond.
</Section>

<section class="BookworkshopCard1">
<p>-Alle workshops zijn mogelijk op locatie in Rotterdam en omgeving.</p>
<p>-Duur: 2 uur.</p>
<p>-Volledig verzorgd en begeleid.</p>
</section>
</section>
<a class="Bookworkshop-button" href="contact.php">Get in touch</a>
<section class="BookworkshopCardBody2">
<section class="TekenImageHeader">
            <img class="TekenImage" src="./Afbeeldingen/Teken.png" alt="Workshop Header">
            <img class="TekenImage2" src="./Afbeeldingen/Teken2.png" alt="Workshop Header">
            <img class="TekenImage3" src="./Afbeeldingen/Teken3.png" alt="Workshop Header">
</section>
</section>
</div>

    <?php include "./Footer.php" ?>
</body>

</html>
