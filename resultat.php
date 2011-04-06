<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
	<title>Comparateur : résultat de la recherche</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php include("php/fonctions.php"); ?>
	<?php include("php/head.php"); ?>
	<?php include("php/menu.php"); ?>
	
	<div id='corps'>
		<?php 
			//vérification de la validité du formulaire précédent.
			if(empty($_POST["recherche"])){
				echo "<p>Le champ de recherche est vide.<p/>".
				     "Veuillez compléter de nouveau le formulaire de recherche.";
				
			}else{
				echo "<p>Vous recherchez : ".$_POST["recherche"]."</p>";
				echo "<p>";
				connection_base();
				$req='Select nom_p,description From Produit Where description like "%'.$_POST["recherche"].'%"';
				$res=execute_requete($req);
				
				foreach($res as $tab){
					echo "<p id='titreP'>".$tab["nom_p"]."</p>";
					echo "<p id='description'>description : ".$tab["description"]."</p>";
					echo "<hr/><br/>";
				}

				echo "</p>";
				
				deconnection_base();
			}

		?>
		<?php include("php/formulaireRecherche.php"); ?>

	</div>

	<?php include("php/foot.php"); ?>


</body>
</html>
