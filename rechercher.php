<?php

$servername = "localhost";
$username = "pelodie";
$password = "pelodie@2017";



if (!empty($_GET['requete']) && isset($_GET['requete']) ){

    $keyword = $_GET['requete'];

    if (isset($_GET['page'])){

        $page =$_GET['page'];

    }else{

        $page=1;
    }

    $nbParPage = 4;
    $count = ($page-1)*$nbParPage;

    try {

        $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $stmt = $conn->prepare("SELECT COUNT(id) as nbMusee FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ORDER BY id DESC LIMIT 0,4 ") or die (mysql_error());
        $stmt->bindParam(':requete', $keyword);
        $stmt->execute();
        $result = $stmt->fetch();

        $totalRecherche = $result['nbMusee'];
        $totalParPage = ceil($totalRecherche/$nbParPage);


        $stmt = $conn->prepare("SELECT * FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ORDER BY id DESC LIMIT :count, :parPage ") or die (mysql_error());
        $stmt->bindParam(':requete', $keyword);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->bindParam(':parPage', $nbParPage,  PDO::PARAM_INT);
        $stmt->execute();

        $musees=$stmt->fetchAll();
    }


    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr_FR">
    <head>
        <title> </title>


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>



        <div class="container-fluid">
            <div class="paint"></div>
            <div class="paint2"></div>
            <div class="background">

                <div class="row">
                    <div class="col-lg-6">

                        <h4>Annuaire des <span class="underligned">musées de France</span></h4>
                    </div>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                            <h5>&mdash; Rechercher un musée</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                            <form id ="formulaire" action="rechercher.php" method="GET">
                                <input class="rechercherinput" type="text" name="requete" size="10">
                                <input id="ok" type="submit" value="Ok">
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                            <p class="asterisque">* par département, musée, ville ou code postal</p>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <h6>&mdash; Liste des musées</h6>
                        </div>
                    </div>



                    <?php
                    if (!empty($totalRecherche) && $totalRecherche>1){
                        echo "<p class='resultnb'> Il y a ".$totalRecherche." résultats pour la recherche  ".$keyword.".</p>";

                        foreach ($musees as $musee):

                    ?>


                    <div class="col-lg-6">
                        <div class="museetxt"><p><?=$musee['nom_du_musee'] ?></p></div> 
                    </div>




                    <?php endforeach;

                        for ($i=1; $i <= $totalParPage; $i++) { 
                            if($i == $page){
                                echo $i."/";
                            }else{
                                echo "<a href=\"rechercher.php?requete=$keyword&page=$i\">$i</a>";
                            }
                        }

                    }else if(!empty($totalRecherche) && $totalRecherche=1 ) {
                        echo " Il y a ".$totalRecherche." résultat pour la recherche  ".$keyword.".";

                        foreach ($musees as $musee):

                    ?>

                    <div class="resulttxt col-lg-6">
                        <div class="museetxt"><p><?=$musee['nom_du_musee'] ?></p></div> 
                    </div>




                    <?php endforeach;

                        /*          for ($i=1; $i <= $totalParPage; $i++) { 
                        if($i == $page){
                            echo $i." ";
                        }else{
                            echo "<a href=\"rechercher.php?requete=$keyword&page=$i\">$i</a>";
                        }
                    }*/
                    }else {
                        if(isset($totalRecherche)){
                            if ($totalRecherche==0){
                                echo " Aucun résultat pour la recherche.";
                            }
                        }
                    }
                    ?>  

                    <div class="row">
                        <div class="col-lg-2 col-lg-offset-10">
                            <a class="retour" href="index.php">Retour à l'accueil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>








        <!--
<div class="resulttxt">
<div class="row">
-->

        <!--
<div class="col-xs-12 col-sm-6 vignette">
<div class="museetxt">
<p>Galerie d'Anatomie Comparée et de Paléontologie (Muséum d'Histoire Naturelle)</p>
</div>
</div>


<div class="col-xs-12 col-sm-6 vignette">
<div class="museetxt">
<p>Musée du Louvre de Paris</p>
</div>
</div>



<div class="container">
<div class="row">
<div class="col-xs-12 col-sm-6 vignette">
<div class="museetxt">
<p>Musées des Beaux-Arts de Besançon</p>
</div>
</div>

<div class="col-xs-12 col-sm-6 vignette">
<div class="museetxt">
<p>Musée des Arts-Déco de Strasbourg</p>
</div>
</div>
</div>
</div>
-->
        <!--
</div>    
</div>
-->
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


    </body>
</html>