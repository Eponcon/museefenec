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
	    

	    $stmt = $conn->prepare("SELECT * FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%')  ") or die (mysql_error());
	    $stmt->bindParam(':requete', $requete);
	    $stmt->execute();


	    $results=$stmt->fetchAll();

	    $nb_resultats = $stmt->rowCount();

	    }

		catch(PDOException $e) {
	    	echo "Connection failed: " . $e->getMessage();
	   	}

	   	// afficher le nombre de résultats
		echo "<p>Il y a ".$nb_resultats;
		 	 
			if($nb_resultats > 1) { 
			 	echo " résultats pour la recherche ".$requete; 

			} else { 
				echo " résultat pour la recherche ".$requete;
			}
			".</p>";

			// afficher les titres et photos en fonction des résultats
			foreach ($results as $result){
			$adr_img = $result['lien_image'];
			echo "<div><p>".$result['nom_du_musee']."</p></div>";
			echo "<div><img src='".$adr_img."'></div>";
			}
		



			//test pagination
			$messagesParPage=5; //Nous allons afficher 5 messages par page.
	 
		
			$retour_total=mysql_query('SELECT COUNT(*) AS total FROM musee LIMIT 4' ); //Nous récupérons le contenu de la requête dans $retour_total
			$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
			$total=$donnees_total['lien_image']; //On récupère le total pour le placer dans la variable $total.
			 
			//Nous allons maintenant compter le nombre de pages.
			$nombreDePages=ceil($total/$messagesParPage);
			 
			if(isset($_GET[''])) // Si la variable $_GET['page'] existe...
			{
			     $pageActuelle=intval($_GET['page']);
			 
			     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
			     {
			          $pageActuelle=$nombreDePages;
			     }
			}
			else // Sinon
			{
			     $pageActuelle=1; // La page actuelle est la n°1    
			}
		}
	?>	 
</body>
</html>