<?php
require_once ('conf.php');
global $yhendus;
//peitmine, avalik=0
if(isset($_REQUEST["peitmine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised SET avalik=0 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["peitmine"]);
    $kask->execute();
}
//avalikustamine, avalik=1
if(isset($_REQUEST["avamine"])) {
    $kask = $yhendus->prepare('
    UPDATE valimised SET avalik=1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["avamine"]);
    $kask->execute();
}
//kustutamine
if(isset($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM valimised WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutasid"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
//tuhistamine
if(isset($_REQUEST["tühistamine"])){
    $kask=$yhendus->prepare("UPDATE valimised SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["tühistamine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}if(isset($_REQUEST['komtuhistamine'])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid="" WHERE id=?');
    $kask->bind_param('s', $_REQUEST['komtuhistamine']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
    <!Doctype html>
    <html lang="et">
    <head>
        <title>Haldusleht</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <?php
    include('navigation.php');
    ?>
    <body>
    <h1>Valimiste nimede juhtimine</h1>
    <?php
    //valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid, avalik FROM valimised');
    $kask->bind_result($id, $nimi, $punktid, $kommentaarid, $avalik);
    $kask->execute();
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Punktid</th><th>Kommentaar</th><th>Staatus</th><th>Avatud või peidetud</th><th>Administraatori toimingud:</th>";

    while($kask->fetch()){
        $avatekst="Avatud";
        $param="Avatud";
        $seisund="Peidetud";
        if($avalik==1){
            $avatekst="Peita";
            $param="Peidetud";
            $seisund="Avatud";
        }

        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($punktid)."</td>";
        echo "<td>".($kommentaarid)."</td>";
        echo "<td>".($seisund)."</td>";
        echo "<td><a href='?$param=$id'>$avatekst</a></td>";
        echo "<td><a href='admin.php?kustutasid=$id'> Kustuta nimed </a><td><a href='admin.php?tuhistamine=$id'> Lähtestada punktid </a><td><a href='admin.php?komtuhistamine=$id'> Kustuta kommentaarid</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <div class="link">
        <a href="https://https://github.com/Limon4egg/valimised" target="_blank">GitHub link</a>
    </div>
    </body>
    </html>
<?php
$yhendus->close();
include ('../footer.php');
//Ülesanne.
// Lehe värskendamine ei lisa punkti.
// Haldusleht -võimaldab nimede kustutamine
// Halduslehel saab punktid panna nulliks
// Navigeerimismenüü + CSS kujundus<?php