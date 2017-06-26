<?php
$servername = "localhost";
$username = "pelodie";
$password = "pelodie@2017";


try {
    $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    // set the PDO error mode to exception

    $stmt = $conn->prepare("SELECT * FROM musee WHERE id BETWEEN 1 AND 20 ORDER BY RAND() LIMIT 8");

    $stmt->execute();
    $musees = $stmt->fetchAll();
}

catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>   


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Annuaire des musées de France</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="service de transfert de fichiers volumineux">

        <!--mise à l'échelle réelle-->
        <meta name="viewport" content="initial-scale=1.0">

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

                <div class="row">
                    <div class="col-xs-12">

                        <h4>Annuaire des <span class="underligned">musées de France</span></h4>
                    </div>
                </div>

                <div class="container page2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-8">
                            <a class="rechercher" href="rechercher.php">&mdash; Cliquez pour rechercher un musée</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h5 class="selection">La sélection de la semaine</h5>
                        </div>
                    </div>

                    <?php 
                    $i=0;
                    foreach ($musees as $musee):

                    ?>

                    <div class="aleatoire">
                        <div class="col-lg-3 ligne1">
                            <div type="button" class="btn-lg1" data-toggle="modal" data-target="#myModal<?=$musee['id']?>"><h2><?=$musee['nom_du_musee']?></h2>
                            
                            <?php
    
                            if($i<4){
                            
                               if($i%2){
                                    echo '<img src="00-images/pixelate-3.JPG">';

                                }else{
                                    echo '<img src="00-images/pixelate-5.JPG">';

                                }
                            
                            }else{
                                 if($i%2){
                                    echo '<img src="00-images/pixelate-5.JPG">';

                                }else{
                                    echo '<img src="00-images/pixelate-3.JPG">';

                                }
                            }
                            
                            $i++;
                            ?></div>
                        </div>
                    </div>

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
                                            <p class="siteweb">Site web :</p>
                                            <div class="sitemusee"><?=$musee['site_web']?></div>
                                            <p class="adresse">Adresse :</p>
                                            <div class="adressemusee"><?=$musee['adresse']?></div>
                                            <div class="ville"><?=$musee['ville']?></div>
                                            <div class="nomreg"><?=$musee['nom_reg']?></div>
                                        </div>
                                        <div class="col-lg-4">

                                            <p class="tel">Téléphone :</p>
                                            <div class="telmusee"><?=$musee['telephone']?></div>
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

                    <?php endforeach;

                    ?>  

                </div>
            </div>
        </div>

        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    </body>
</html>
