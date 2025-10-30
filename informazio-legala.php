<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazio legala</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/style.js"></script>
    <link rel="shortcut icon" href="media/logo.ico" />
</head>

<body>

    <div class="margin">
    <?php
    include("menu.php");
    ?>

    <article class="informazio-legala">

        <h2>1. Sartzeko baldintzak.</h2>

        <p>Webgune honen xedea da gure zerbitzuei eta jarduerei buruzko informazioa ematea. Webgunea erabiltzeak esan
            nahi du erabiltzaileak baldintza hauek onartzen dituela, beraz, baldintzen edukiarekin ados ez badago, ez du
            webgunea erabiliko, ez eta bertan eskaintzen diren zerbitzuak ere. FP TXURDINAGA egoki iritzitako aldaketak
            egiteko eskubidea du eta aurrez ohartarazi gabe aldatu, kendu edo gehitu ditzake edukiak edo/eta zerbitzuak,
            baita hauek aurkezteko eta kokatzeko modua eta webgunea erabiltzeko baldintzak ere.<br><br>Erabiltzaileak
            onartzen du webgunean sartzeko eta bertako edukiak erabiltzeko askatasun osoa duela, kontzienteki egiten
            duela, bere erantzukizunpean, eta ondorioz, konpromiso hauek hartzen dituela:</p>

        <ul>
            <li>Webgunea ez duela erabiliko legearen, moralaren eta, oro har, ordena publikoaren aurkako jarduerak
                egiteko, eta zilegi eta zintzo erabiliko duela, baldintza orokor hauen arabera. Era berean, ezin izango
                du webgunea kaltetu, baliogabetu, gainkargatu edo hondatu dezakeen ekintzarik egin, ez eta gainerako
                erabiltzaileek normaltasunez erabil dezaten eragotzi ere.</li>
            <li>Ezingo du webguneko edukirik manipulatu edo aldatu, titularraren berariazko eta idatzizko baimenik gabe.
                Titularraren baimenik gabe egindako aldaketa edo manipulazioen erantzukizunik ez du izango titularrak.
            </li>
            <li>Edukiak ez dituela erreproduzitu, kopiatu, banatu, publikoki komunikatu, eraldatu edo aldatuko, dagokien
                eskubideen titularraren nahitaezko baimenik gabe edo legez baimenduta ez badago; era berean, ez dituela
                ezabatu, saihestu edo manipulatuko FP TXURDINAGA edo haren edukietan sartutako titularren eskubideen
                Copyright eta gainerako identifikazio-datuak, ez eta babesteko gailu teknikoak edo eduki horiek izan
                ditzaketen informaziorako mekanismoak ere.</li>
            <li>Ez dituela sartuko edo hedatuko webgunean kalteak eragin ditzaketen datu-programak (birusak edo edozein
                software kaltegarri). </li>
        </ul>

        <p>FP TXURDINAGA ez du bermatzen webgunearen eskuragarritasuna eta jarraitutasuna, eta ez du bere gain hartzen
            gerta daitekeen edozein kalte-galeraren erantzukizuna, ez eta akats teknikoena ere, birusak edo beste
            elementu kaltegarri batzuk barne, edozein dela ere haien izaera, informazioaren erabileraren eta webgunean
            jasotako gaien ondorioz.</p>

        <h2>2. Cookien erabilera.</h2>

        <p>Zerbitzu hobea emateko, FP TXURDINAGA cookie izeneko informazio-fitxategi txikiak gorde ditzake
            erabiltzailearen ordenagailuan. Eskaintzen diren zerbitzuetako batzuek behar bezala funtzionatzeko
            erabiltzen dira fitxategi horiek, baita erabilera-estatistikak egiteko, webgunean arazoak diagnostikatzeko
            eta eskainitako zerbitzuetako batzuk administratzeko ere. Erabiltzaileak bere nabigatzailea konfiguratu
            dezake, bere ekipoan cookien onarpena mugatzeko edo murrizteko. Informazio gehiago nahi izanez gero,
            bisitatu gure cookien politika.</p>

        <h2>3. Erantzukizunak.</h3>

            <p>Erabiltzailea izango da FP TXURDINAGA edo beste edozeinek jasan ditzakeen kalte-galeren erantzulea,
                baldintza orokor hauen arabera bete beharreko edozein betebehar ez betetzearen ondorioz izan bada galera
                hori. <br><br>FP TXURDINAGA ez du bere gain hartzen webguneak kanpoko edukiekin izan ditzakeen
                hiperesteken gaineko inolako erantzukizunik, eta ez du horrelakoen kontrolik egiten; hala ere, jakin
                bezain laster kenduko ditu legez kanpoko edukiak dituzten estekak.</p>

            <h2>4. Jabetza intelektuala eta industriala.</h2>

            <p>Erabiltzaileak onartzen du webguneko eduki guztiak, eta, zehazki, informazio eta material guztiak,
                edukien egitura, hautaketa, antolaketa eta prestazioa, eta horiekin lotuta erabilitako aplikazioen
                garapena, webgunearen titularraren edo, hala badagokio, hirugarrenen jabetza intelektual eta
                industrialeko eskubideek babesten dituztela.</p>

            <p>Erabiltzaileak horiek eskuratzeak edo erabiltzeak ez du inondik eta inora esan nahiko eskubide horiei,
                osorik edo zati batean, uko egitea, eskualdatzea edo lagatzea, eta ez du inolako eskubiderik ematen
                eduki horiek erabiltzeko, aldatzeko, ustiatzeko, erreproduzitzeko, banatzeko edo jendaurrean
                jakinarazteko, FP TXURDINAGA edo dagokien eskubideen hirugarren titularrak horretarako berariazko
                baimena eman ezean.</p>

            <p>FP TXURDINAGA bere webgunearen diseinu grafikoa, menuak, nabigazio-botoiak, kodea, testuak, irudiak,
                testurak, grafikoak eta web orriko beste edozein eduki osatzen duten elementuen titularra da, edo, beste
                kasu batzuetan, elementu horiek erabiltzeko baimena du.</p>

            <p>Orri honetan agertzen diren marka, izen komertzial edo zeinu bereizgarri guztiak FP TXURDINAGA edo/eta
                beste enpresa batzuenak dira. Debekatuta dago etengabe erabiltzea edo deskargatzea, kopiatzea edo
                banatzea, edozein bide erabilita, titularraren nahitaezko baimenik gabe.</p>

            <p>Edozein erabiltzailek edo hirugarrenek uste badu webgunean sartu den edukietako edozeinek bere jabetza
                intelektualaren edo industrialaren eskubideak urratu dituela, jakinarazpen bat bidali beharko dio FP
                TXURDINAGA, bere burua eta ustez urratutako jabetza intelektualaren edo industrialaren eskubideen
                titularra identifikatu beharko ditu, eta eskubide horien ordezkaritzaren titulua edo egiaztagiria
                aurkeztu ere bai.</p>

            <h2>5. Datuen babesa.</h2>

            <p>Zure datuen erabilerari buruzko informazioa lortzeko, kontsultatu gure Pribatutasun Politika.</p>

            <h2>6. Konfidentzialtasuna.</h2>

            <p>Alderdietako edozeinek besteari komunikatzen edo helarazten dion informazio oro, edo alderdietako
                edozeinek eskura duena, konfidentzialtzat joko da, eta ezin izango da zabaldu, erakutsi, erreproduzitu,
                kopiatu, hirugarrenekin eztabaidatu, eta alderdietako batek ere ezin izango du erabili komunikazioa
                eragin zuten helburuetatik kanpoko xedeetarako.</p>

            <h2>7. Legeria aplikagarria eta jurisdikzioa.</h2>

            <p>Baldintza orokor hauek Espainiako legerian xedatutakoaren arabera arautuko dira. Dokumentu honen
                interpretazioaren eta betearazpenaren inguruan alderdien artean sor daitezkeen auzi guztietarako, bi
                aldeak berariaz eta dagozkien beste edozein foruri uko eginez, Bilboko Epaitegi eta Auzitegien
                jurisdikzioaren mende jartzen dira.</p>

    </article>

    </div>

    <?php
    include("footer.php");

    ?>
</body>

</html>