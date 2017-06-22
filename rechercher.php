<!DOCTYPE html>
<html lang="fr_FR">
<head>
	<title> </title>
</head>

<body>


<div class="container-fluid">
            <div class="paint"></div>
            <div class="paint2"></div>
            <div class="background">

                <div class="row">
                    <div class="col-xs-12">

                        <h4>Annuaire des <span class="underligned">musées de France</span></h4>
                        <a href="index.php">Accueil</a>
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
                            <form id ="formulaire" action="rechercher.php" method="Post">

                                <input class="rechercherinput" type="text" name="requete" size="10">
                                <input id="ok" type="submit" value="Ok">
                            </form>
                            
                            <form action="rechercher.php" method="Post">
		<input type="text" name="requete" size="10">
		<input type="submit" value="Ok">
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



                    <div class="resulttxt">
                        <div class="row">
                               
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
                    </div>    
                    </div>
                </div>
            </div>
        </div>
        



</body>
</html>