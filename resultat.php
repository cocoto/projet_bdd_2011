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
		<?php include("php/formulaireRecherche.php"); ?>
		<?php 
			connection_base();
			//on regarde de quelle façon la page a été appelée.
			if(isset($_GET['rayon'])){
				//on affiche tous les produits du rayon.
				$req='Select ';
			}else{
				if(isset($_GET['type'])){
					//on affiche tous les produits de ce type.


				}else{
					//c'est une recherche.
					//vérification de la validité du formulaire précédent.
					if(empty($_POST["recherche"])|| (!isset($_POST["description"]) && !isset($_POST["nom"]))){
						echo "<p>Le champ de recherche est vide.<br/>".
						     "Veuillez compléter de nouveau le formulaire de recherche.</p>";
				
					}else{

						echo "<p>Vous recherchez : ".$_POST["recherche"]."</p><hr/>";
						echo "<p>";

						

						if(isset($_POST["description"])){
							$req='Select id_p,nom_p,description From Produit Where description REGEXP "[[:<:]]'.$_POST["recherche"].'[[:>:]]"';
							$res=execute_requete($req);
						}

						if(isset($_POST["nom"])){
							$req='Select id_p,nom_p,description From Produit Where nom_p REGEXP "[[:<:]]'.$_POST["recherche"].'[[:>:]]"';
							$res=execute_requete($req);
						}
				
						if(isset($_POST["description"]) && isset($_POST["nom"])){
							$req='Select id_p,nom_p,description From Produit Where description REGEXP "[[:<:]]'.$_POST["recherche"].'[[:>:]]" Or nom_p REGEXP "[[:<:]]'.$_POST["recherche"].'[[:>:]]"';
							$res=execute_requete($req);
						}
				
						if(empty($res)){
							echo "<p>Aucun résultat.</p>";
						}else{
							connection_base();
							foreach($res as $tab){
								echo "<p id='titreP'><a href='info_produit.php?id_p=".$tab["id_p"]."' >".$tab["nom_p"]."</a></p>";
								echo "<p id='description'>description : ".$tab["description"]."</p>";
								echo "<hr/><br/>";
							}
	
						}
						echo "</p>";
					}
				}//fin de la recherche
			}

			deconnection_base();


		?>
		

	</div>

	<?php include("php/foot.php"); ?>


</body>
</html>
