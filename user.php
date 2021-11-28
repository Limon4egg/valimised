<?php
require_once('conf.php');
global $yhendus;

if(isset($_REQUEST["punktid"])) {
    $kask = $yhendus->prepare('UPDATE valimised SET punktid=punktid + 1 WHERE id=?');
    $kask->bind_param('i', $_REQUEST["punktid"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["kommentaarid"])){
    $kask = $yhendus->prepare('UPDATE valimised SET kommentaarid=? WHERE id=?');
    $kommenttext=$_REQUEST['kommenttext']."\n";
    $kask->bind_param('si', $kommenttext, $_REQUEST["kommentaarid"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
    <!Doctype html>
    <html lang="et">
    <link rel="stylesheet" type="text/css" href="style.css">
    <head>
        <title>Valimiste leht</title>
    </head>
    <?php
    include('navigation.php');
    ?>
    <main>
        <h1>Valimiste leht</h1>


        <?php
        global $yhendus;
        $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid FROM valimised WHERE avalik=1');
        $kask->bind_result($id, $nimi, $punktid, $kommentaarid);
        $kask->execute();
        echo "<table>";
        echo "<tr><th>Nimi</th><th>Punktid</th><th>Kommentaarid</th><th>Anna oma hääl</th><th>Esitada kommentaar</th>";

        while($kask->fetch()){
            echo "<tr>";
            echo "<td>".htmlspecialchars($nimi)."</td>";
            echo "<td>".($punktid)."</td>";
            echo "<td>".($kommentaarid)."</td>";
            echo "<td><a href='?punktid=$id'>Anna +1 hääl</a></td>";
            echo "<td>
                <form action='?'>
                <input type='hidden' name='kommentaarid' value='$id'>
                <input type='text' id='kommenttext' name='kommenttext' placeholder='Sinu kommentaar'>
                <input type='submit' value='Esitada kommentaar'>
                </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </main>
    <div class="link">
        <a href="https://https://github.com/Limon4egg/valimised" target="_blank">GitHub link</a>
    </div>
</html>
<?php
$yhendus->close();
include ('../footer.php');
/*CREATE TABLE valimised(
    id int primary key auto_increment,
    nimi varchar(100),
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaarid text,
    avalik int DEFAULT 1);

Insert into valimised(nimi, lisamisaeg, punktid, kommentaarid,avalik)
Values ('Karlson', '2021-11-1', 10, 'Väga hea raamat', 1);

Select * From valimised*/
