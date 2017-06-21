<!DOCTYPE html>
<html lang="fr_FR">
<head>
	<title> </title>
</head>

<body>
	<a href="index.php">Accueil</a>
	<form action="rechercher.php" method="Post">
		<input type="text" name="requete" size="10">
		<input type="submit" value="Ok">
	</form>

	<?php
		if(isset($_POST['requete']) && $_POST['requete'] != NULL) {  // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.

		$servername = "localhost";
		$username = "pelodie";
		$password = "pelodie@2017";


		try {
		    $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 	$requete = htmlspecialchars($_POST['requete']);
		   

		    $stmt = $conn->prepare("SELECT COUNT(id) AS nombre FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ") or die (mysql_error());
		    $stmt->bindParam(':requete', $requete);
		    $stmt->execute();
		    $results=$stmt->fetch();
		 	echo "<p>Il y a ".$results['nombre'];
		 	
		 	$articlesparpage=8;
		 	$articles=$stmt->fetch(PDO::FETCH_ASSOC);
		 	$totaldesarticles=$articles['id'];
		 	$nombredepage=ceil($totaldesarticles/$articlesparpage);
			
		

			for ($i=1;$i<= $nombredepage;$i++){
  			  echo '<li><a href="http://vesoul.codeur.online/front/pelodie/museefenec/rechercher.php?page=' . $i . '">' . $i . '</a></li>';
  			}
	   	

  			if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>0 && $_GET['page']<= $nombredepage)
			{
			        $page=intval($_GET['page']);
			}
			else
			{
			        $page=1;
			}


			$premierarticleafficher=$page*$articlesparpage-$articlesparpage;

		    $reponse = $conn->prepare("SELECT * FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ORDER BY `id` DESC LIMIT :offset, :id") or die (mysql_error());
		    $reponse->bindParam(':requete', $requete);
		    $reponse->bindParam(':id', $articlesparpage);
			$reponse->bindParam(':offset', $premierarticleafficher);

		    $reponse->execute();
		    
		    // $results=$reponse->fetchAll();
		    // $nb_resultats = $reponse->rowCount();



		    if($results['nombre'] > 1) { 
			 	echo " résultats pour la recherche ".$requete; 

			} else { 
				echo " résultat pour la recherche ".$requete;
			}
			".</p>";
	    }

		catch(PDOException $e) {
	    	echo "Connection failed: " . $e->getMessage();
	   	}

	   	// afficher le nombre de résultats
		

			// afficher les titres et photos en fonction des résultats
			// foreach ($results as $result){
			// $adr_img = $result['lien_image'];
			// echo "<div><p>".$result['nom_du_musee']."</p></div>";
			// echo "<div><img src='".$adr_img."'></div>";
			// }
	
			
		}
	?>	 
</body>
</html>