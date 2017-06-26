
<?php
$servername = "localhost";
$username = "pelodie";
$password = "pelodie@2017";

try {
    $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    // set the PDO error mode to exception

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SELECT * FROM musee  ORDER BY id DESC LIMIT 6");

}

catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr_FR">
    <head>
        <meta charset="utf-8" />
        <title>Data Musée</title>
    </head>
    <body>
        <a href="rechercher.php">Recherche</a>

        <?php                   
        while($col_musee = $stmt->fetch()) {

            $adr_img = $col_musee['lien_image'];

            echo "<div>";
            echo "<img src='".$adr_img."'>";
            echo "<div>".$col_musee['nom_du_musee']."</div>";
            echo "<div>".$col_musee['ville'].", ".$col_musee['cp']."</div>";
            echo "</div>";
        }       
        ?>      
    </body>
</html>