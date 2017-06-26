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
        <title>Annuaire des musées de France</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="container-fluid">
            <div class="paint"></div>
            <div class="paint2"></div>
            <div class="background">

                <div id ="carre">
                    <svg version="1.1" id="carre" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:none;stroke:#DCF9F7;stroke-width:4;stroke-miterlimit:10;}
                        </style>
                        <rect x="4" y="3.6" class="st0" width="61.8" height="61.8"/>
                    </svg>
                </div>


                <div id="triangle">
                    <svg version="1.1" id="triangle" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:none;stroke:#DCF9F7;stroke-width:4;stroke-miterlimit:10;}
                        </style>
                        <polygon class="st0" points="6.1,35.5 59.5,4.7 59.5,66.3 "/>
                    </svg>
                </div>


                <div id ="cercle">
                    <svg version="1.1" id="cercle" xmlns="http://www.w3.org/2000/svg"             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:none;stroke:#DCF9F7;stroke-width:4;stroke-miterlimit:10;}
                        </style>
                        <circle class="st0" cx="34.8" cy="35.4" r="31.9"/>
                    </svg>
                </div>

                <div id ="hexagone">
                    <svg version="1.1" id="hexagone" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 70 70" style="enable-background:new 0 0 70 70;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:none;stroke:#DCF9F7;stroke-width:4;stroke-miterlimit:10;}
                        </style>
                        <polygon class="st0" points="33.4,3.2 60.9,19.1 60.9,50.9 33.4,66.8 5.8,50.9 5.8,19.1 "/>
                    </svg>
                </div>


                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-6">

                        <h4>Annuaire des <span class="underligned">musées de France</span></h4>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                        <h5>&mdash; Rechercher un musée</h5>
                    </div>


                    <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                        <form id ="formulaire" action="rechercher.php" method="GET">
                            <input class="rechercherinput" type="text" name="requete" size="10">
                            <input id="ok" type="submit" value="Ok">
                        </form>
                    </div>



                    <div class="col-xs-12 col-sm-4 col-sm-offset-9">
                        <p class="asterisque">* par département, musée, ville ou code postal</p>
                    </div>



                    <div class="col-xs-12 col-sm-3 col-sm-offset-9">
                        <a class="retour" href="selection.php">&mdash; Retour à la sélection</a>
                    </div>


                    <div class="col-xs-12 col-sm-9">
                        <h6>&mdash; Liste des musées</h6>
                    </div>

                </div>

                <?php
                if (!empty($totalRecherche) && $totalRecherche>1){
                    echo "<p class='resultnb'> Il y a ".$totalRecherche." résultats pour la recherche  ".$keyword.".</p>";
                    echo "<div class='container'>";
                    echo "<div class='row'>";

                    foreach ($musees as $musee):

                ?>
                <!-- nom du musée qui s'affiche en résultat -->          

                <div class="col-lg-6" style="height: 250px;">

                    <div type="button" class="btn-lg" data-toggle="modal" data-target="#myModal<?=$musee['id']?>"><p class="museetxt"><?=$musee['nom_du_musee'] ?></p></div> 
                </div>


                <!-- pour morgane la livebox sinon le lightbox -->   

                <div class="modal fade" id="myModal<?=$musee['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-11">
                                        <h4 class=" modal-title" id="myModalLabel"><?=$musee['nom_du_musee'] ?></h4>
                                    </div>

                                    <div class="col-lg-1">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <img src="<?=$musee['lien_image']?>">
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="web">
                                            <p class="siteweb">Site web :</p>
                                            <div class="sitemusee"><?=$musee['site_web']?></div>
                                        </div>
                                        <div class="divadresse">
                                            <p class="adresse">Adresse :</p>
                                            <div class="adressemusee"><?=$musee['adresse']?></div>
                                            <div class="ville"><?=$musee['ville']?></div>
                                            <div class="nomreg"><?=$musee['nom_reg']?></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="telephone">
                                            <p class="tel">Téléphone :</p>
                                            <div class="telmusee"><?=$musee['telephone']?></div>
                                        </div>
                                        <div class="heures">
                                            <p class="horaires">Horaires :</p> 
                                            <div class="ouverture"><?=$musee['periode_ouverture']?></div>
                                            <div class="fermeture"><?=$musee['fermeture_annuelle']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <?php endforeach;
                    echo "</div>";
                    echo "</div>";

                    echo "<ul class='pagination'>";
                    if($totalRecherche >4){
                        echo"<li><a href='#'>&laquo;</a></li>";
                    }



                    for ($i=1; $i <= $totalParPage; $i++) { 
                        if($i == $page){   
                            if($totalRecherche <=4) {
                                echo "";
                            } else {

                                echo "<li class='active'><a href='#'>$i</a></li>";
                            }
                        }else{
                            echo "<li><a href=\"rechercher.php?requete=$keyword&page=$i\">$i</a></li>";
                        }
                    }
                    if($totalRecherche >4){
                        echo "<li><a href='#'>&raquo;</a></li>";
                    }
                    echo "</ul>";


                }else if(!empty($totalRecherche) && $totalRecherche=1 ) {
                    echo " Il y a ".$totalRecherche." résultat pour la recherche  ".$keyword.".";

                    foreach ($musees as $musee):

                ?>

                <div class="col-lg-6" style="height: 250px;">
                    <div type="button" class="btn-lg" data-toggle="modal" data-target="#myModal"><p class="museetxt"><?=$musee['nom_du_musee'] ?></p></div>
                </div>


                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p class="modal-title" id="myModalLabel"><?=$musee['nom_du_musee'] ?></p>
                            </div>
                            <div class="modal-body">
                                <img src="<?=$musee['lien_image']?>">
                                <p>Site web :</p>
                                <div><?=$musee['site_web']?></div>
                                <p>Adresse :</p>
                                <div><?=$musee['adresse']?></div>
                                <div><?=$musee['ville']?></div>
                                <div><?=$musee['nom_reg']?></div>
                                <p>Téléphone :</p>
                                <div><?=$musee['telephone']?></div>
                                <p>Horaire :</p>
                                <div><?=$musee['periode_ouverture']?></div>
                                <div><?=$musee['fermeture_annuelle']?></div>
                            </div>
                            <div class="modal-footer">                   
                            </div>
                        </div>
                    </div>
                </div>


                <?php endforeach;

                }else {
                    if(isset($totalRecherche)){
                        if ($totalRecherche==0){
                            echo " Aucun résultat pour la recherche.";
                        }
                    }
                }
                ?> 
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>






    </body>
</html>