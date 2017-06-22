<!DOCTYPE html>
<html lang="fr_FR">
<head>
	<title> </title>
</head>

<body>
	<a href="index.php">Accueil</a>
	<form action="rechercher.php" method="GET">
		<input type="text" name="requete" size="10">
		<input type="submit" value="Ok">
	</form>

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

	 		$nbParPage = 8;
	 		$count = ($page-1)*$nbParPage;

	 		try {

			    $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			    $stmt = $conn->prepare("SELECT COUNT(id) as nbMusee FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ORDER BY id DESC LIMIT 0,8 ") or die (mysql_error());
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

	 	if (!empty($totalRecherche) && $totalRecherche>1){
	 	echo " Il y a ".$totalRecherche." résultats pour la recherche  ".$keyword.".";

		 	foreach ($musees as $musee):
		 	
		 	?>

		 	<div>
		 		<h2><?=$musee['nom_du_musee'] ?></h2>
		 		<img src="<?=$musee['lien_image']?>"; 
		 	</div> </hr>

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

	 	<div>
	 		<h2><?=$musee['nom_du_musee'] ?></h2>
	 		<img src="<?=$musee['lien_image']?>"; 
	 	</div> </hr>
 
	 	<?php endforeach;

	 	for ($i=1; $i <= $totalParPage; $i++) { 
	 		if($i == $page){
	 			echo $i."/";
	 		}else{
	 			echo "<a href=\"rechercher.php?requete=$keyword&page=$i\">$i</a>";
	 		}
	 	}

	 	}else if(!empty($totalRecherche) && $totalRecherche==0){
	 	echo " Il n'y a aucun résultat pour la recherche.";
	 }


		// condition vérifie que la requete n'est pas vide 
		// if(isset($_GET['requete']) && $_GET['requete'] != NULL) {


		// // connection à la base de données
		// try {

		// 	    $conn = new PDO("mysql:host=$servername;dbname=pelodie", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		// 	    // set the PDO error mode to exception
		// 	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// 	 	$requete = htmlspecialchars($_GET['requete']);

		// 	 	// requête pour le moteur de recherche
		// 	 	$sql = $conn->prepare("SELECT COUNT(id) as nbMusee FROM musee");
		// 	    $sql->execute();
		// 	    $results2=$sql->fetch();
		// 	   	$nbMusee =  $results2['nbMusee'];
		// 	   	$nbMuseeParPage = 8;
		// 	   	$nbPageCourante = 1;


		// 	 	// requête pour le moteur de recherche
			 	// $stmt = $conn->prepare("SELECT * FROM musee WHERE nom_dep LIKE CONCAT('%', :requete, '%') OR nom_du_musee LIKE CONCAT('%', :requete, '%') OR adresse LIKE CONCAT('%', :requete, '%') OR ville LIKE CONCAT('%', :requete, '%') OR nom_reg LIKE CONCAT('%', :requete, '%') OR cp LIKE CONCAT('%', :requete, '%') ORDER BY id DESC LIMIT 0,8 ") or die (mysql_error());
			  //   $stmt->bindParam(':requete', $requete);
		// 	    $stmt->execute();
		// 	    $results=$stmt->fetchAll();
			
			
		//     }

		// 	catch(PDOException $e) {
		//     	echo "Connection failed: " . $e->getMessage();
		//    	}


		//    	var_dump($results);
		//    	// echo- affichage des résultats
		// 	 	echo "<p>Il y a ".$nbMusee;
		 	
		// 	 if($results['nombre'] > 1) { 
		// 	 	echo " résultats pour la recherche ".$requete; 
			 	

		// 	} else { 
		// 		echo " résultat pour la recherche ".$requete;
		// 	}
		// 	".</p>";

			
			
			
			
			
		// }



	?>	 
</body>
</html>