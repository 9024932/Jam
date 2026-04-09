<?php require_once __DIR__ . "/auth.php"; auth_init(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>

<body>

    <?php include "./Navbar.php" ?>

    <section class="Section1">
        <section class="right">
            <h1 class="TitelWebsite">Ontdek Creatieve <br> Workshops</h1>
            <p class="Introductie">Volg inspirerende workshops gegeven door <br> professionele kunstenaars in heel Nederland.</p>
            <div class="buttonSection">

                <a class="OverMijButton" href="Overmij.php">Over mij</a>
                <a class="WorkshopsButton" href="Contact.php">Contact</a>
            </div>
            <p class="Beschrijving">Bij WorkshopHub brengen we creatieve mensen samen met <br> inspirerende workshops. Leer schilderen, illustreren en <br> ontwerpen van professionele kunstenaars.</p>
        </section>

        <section class="imageHeader">
            <img class="HeaderImage" src="./Afbeeldingen/WorkshopHeader.png" alt="Workshop Header">
        </section>
    </section>

    <section class="Section2">
        <section class="Tekst">
            <p class="Locatie">Door heel nederland</p>
            <p class="Begeleiding">Begeleiding door professionele kunstenaar</p>
            <p class="Locatie">Locatie op eigen bedrijven</p>
            <p class="Groepsgrootte">Voor bedrijven en groepen 20 - 50 personen</p>
        </section>
        <div class="Section3Icons" aria-hidden="true">
            <img src="./Afbeeldingen/world.png" alt="">
            <img src="./Afbeeldingen/paintlog.png" alt="">
            <img src="./Afbeeldingen/loclog.png" alt="">
            <img src="./Afbeeldingen/men.png" alt="">
        </div>
    </section>




<section class="Section3">
        <section class="Tekst2">
            <h2 class="WorkshopTitel">Schilderworkshop</h2>
            <p class="Prijs">Vanaf €10 per persoon</p>
            <p class="Duur">Duur: 2 – 3 uur</p>
            <p class="Geschikt">Geschikt voor bedrijven en teams</p>
            <p class="Groepsgrootte">Groepsgrootte: 20 – 50 personen</p>
        </section>
        <a class="FAQSButton" href="FAQS.php">Vragen?</a>
<section class="Section4">
        <div class="Section4Icons" aria-hidden="true">
            <img src="./Afbeeldingen/men.png" alt="">
            <img src="./Afbeeldingen/paintlog.png" alt="">
            <img src="./Afbeeldingen/world.png" alt="">
            <img src="./Afbeeldingen/loclog.png" alt="">
        </div>
</section>
<section class="ImageWorkshop">
        <img class="WorkshopImage" src="./Afbeeldingen/WorkshopImage.png" alt="Workshop Image">
</section>
</section>




    <?php include "./Footer.php" ?>
</body>

</html>
