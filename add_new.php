<?php
require_once('conf.php');
global $yhendus;
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare('INSERT INTO valimised(nimi, lisamisaeg) Values (?, Now())');
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>

    <!Doctype html>
    <html lang="et">
    <head>
        <title>Uue märkmelehe lisamine</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <?php
    include('navigation.php');
    ?>
    <main>
        <header>
            <h1>Uue nime lisamine</h1>
        </header>
        <form action="?">
            <label for="uusnimi">Nimi</label>
            <input type="text" id="uusnimi" name="uusnimi" placeholder="Uus nimi">
            <input type="submit" value="OK">
        </form>
    </main>
    <div class="link">
        <a href="https://https://github.com/Limon4egg/valimised" target="_blank">GitHub link</a>
    </div>
    </body>
    </html>
<?php
$yhendus->close();
include ('../footer.php');