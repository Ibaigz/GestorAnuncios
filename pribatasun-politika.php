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

        <h2>1. DATUEN TRATAMENDUAREN ARDURADUNAREN DATUAK</h2>

        <p>
            - Erakundearen izena: FP TXURDINAGA FUNDAZIO ZIBILA<br>
            - Helbidea: Ornilla Doctor Kalea, 2, 48004 Bilbo, Bizkaia<br>
            - IFZ: G95735916<br>
            - Telefonoa: 944 004 004<br>
            - Posta elektronikoa: <a href="">idazkaria@fpTXurdinaga.com</a><br>
            - Datuen babeserako ordezkariaren harremanetarako datuak: TXURDINAGA S.L.<br>
            - DBO harremanetarako: <a href="">txurdinagacifp</a><br>
        </p>
        <h2>2. WEBGUNEAREN BIDEZ BILDUTAKO DATUEN TRATAMENDUA</h2>

        <p>
            FP TXURDINAGA web orria erabiltzeagatik edo nabigatzeagatik bil ditzakeen datuak, gure inprimakien bidez edo
            posta elektronikoz jaso ditzakeenak edo hirugarren batek FP TXURDINAGA duen kontratuzko harremanaren
            ondorioz, Fundazio honek bil ditzakeen datuak datu pertsonalak dira. Zenbaitetan, jakinarazten dizugu gure
            webgunea erabili eta nabigatze hutsagatik FP TXURDINAGA datu hauek biltegiratuko dituela:<br>
            <ul>
                <li>IP helbidea.</li>
                <li>Nabigatzailearen bertsioa.</li>
                <li>Sistema eragilea.</li>
                <li>Webguneko ikustaldiaren edo nabigazioaren iraupena.</li>
            </ul>
            Informazio hori Google Analyticsen bidez gorde daiteke; beraz, Googleren Pribatutasun Politikari lotzen
            gatzaizkio, Google baita informazio hori bildu eta tratatzen duena.
            Era berean, web orrian Google Mapsen erabili daitekeenez, zure kokapenerako sarbidea izan dezake, uzten
            badiozu, gure egoitzetarako distantziari eta/edo bideei buruzko zehaztasun handiagoa eskaintzeko. Horri
            dagokionez, Google Mapsek erabilitako Pribatutasun Politikari lotzen gatzaizkio, datu horien erabilera eta
            tratamendua ezagutzeko.
        </p>

        <h3>1. Harremanetarako inprimakia.</h3>
        <ol>
            <li>Xedea. Inprimaki honen xedea da harremanetarako inprimakien bidez zuk egindako informazio-eskaerari
                erantzutea.</li>
            <li>Legitimazioa. Interesdunaren adostasuna.</li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
        </ol>

        <h3>2. Webgunean dauden posta elektronikoen bidez jasotako informazioa</h3>

        <ol>
            <li>Xedea. Zure informazio eskaerari erantzutea.</li>
            <li>Legitimazioa. Posta elektroniko bidez eskaria bidaltzen diguzunean, zuk zeuk emandako baimena.</li>
            <li>Hartzaileak: Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
        </ol>

        <h3>3. Bat-bateko hautagaitzak.</h3>

        <ol>
            <li>Xedea. FP TXURDINAGA langile-hautaketa prozesuetan zuk parte hartzea. </li>
            <li>Legitimazioa. Bat-bateko hautagaitza bidez interesatuak ematen digun baimena.</li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
            <li>Legitimazioa. Kontratua burutzea eta interesatuaren baimena.</li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
        </ol>


        <h3>4. Fundazioaren ekitaldiei buruzko publizitatea bidaltzea:</h3>

        <ul>
            <li>Xedea. FP TXURDINAGA antolatzen dituen jarduerei eta ekitaldiei buruzko publizitatea bidaltzea eta
                bidalketa kudeatzea, onartzen duten eta izena ematen duten erabiltzaileei.</li>
            <li>Legitimazioa. Bidalketa onartzen duten interesatuen baimena, horretarako, dagokien laukia markatu behar
                dute.</li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
        </ul>

        <h2>3. BESTE DATU TRATAMENDU BATZUK</h2>
        <h3>1. Harreman profesionaletarako soilik.</h3>
        <ul>
            <li>Xedea. FP TXURDINAGA zure datu pertsonalak gure arteko harreman profesionala mantentzeko tratatzen
                ditugu. </li>
            <li>Legitimazioa. Tratamenduaren arduradunaren interes legitimoa, betiere interesdunaren interesa edo
                oinarrizko eskubide eta askatasunak gailentzen ez badira.</li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean.</li>
        </ul>

        <h3>2. Soilik sare sozialen bidez harremanetan jartzeko</h3>

        <ul>
            <li>Xedea. FP TXURDINAGA zure datu-pertsonalak xede hauekin tratatzen ditugu:</li>
            <li>Legitimazioa. Tratamenduaren arduradunaren interes legitimoa, baita dagokion sare sozialaren inguruan
                sor daitekeen kontratuzko harremana onartzea ere. </li>
            <li>Hartzaileak. Zure datuen hartzaileak gure erakundeko arloak izango dira, bai eta datuak lagatzen
                dizkiegun hirugarrenak ere, datuen babesaren arloan indarrean dagoen araudian xedatutakoaren arabera
                zilegi denean. Hala ere, gehien erabiltzen ditugun sare sozialen pribatutasun-politika berrikustea
                gomendatzen dugu; izan ere, sare sozialek, iparramerikarrak direnez, datuak Estatu Batuetara transferitu
                ditzakete.</li>
        </ul>

        <h3>3. Gure dohaintza-emaileentzat eta borondatezko ekarpenentzat soilik.</h3>

        <ul>
            <li>Xedea. FP TXURDINAGA zure datuak tratatzen ditugu zure borondatezko ekarpenaren/dohaintzaren ondoriozko
                betebeharrak kudeatzeko.</li>
            <li>Legitimazioa. Borondatezko ekarpenetik eratorritako betebeharrak betetzea, Irabazi-asmorik gabeko
                erakundeen zerga-araubideari eta mezenasgoaren zerga-pizgarriei buruzko abenduaren 23ko 49/2002 Legearen
                arabera.</li>
            <li>Hartzaileak. Zure datuak zerga administrazioari jakinaraziko zaizkio, Irabazi-asmorik gabeko erakundeen
                zerga-araubideari eta mezenasgoaren zerga-pizgarriei buruzko abenduaren 23ko 49/2002 Legea betetzeko.
            </li>
        </ul>

    </article>
    </div>

    <?php
    include("footer.php");

    ?>
</body>

</html>