<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
	<title>Comparateur : résultat de la recherche</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css"/>
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
				$req='Select id_p ident,nom_p,description,prix From Tarif NATURAL JOIN Produit NATURAL JOIN (Select type From Type where rayon="'.$_GET['rayon'].'") as T1 HAVING Prix <= ALL (SELECT prix From Tarif where Id_p=ident)';
				
				$res=execute_requete($req);
				foreach($res as $tab){
					echo "<p class='titreP'><a href='info_produit.php?id_p=".$tab["ident"]."' >".$tab["nom_p"]."</a></p>";
					echo "<p class='description'>description : ".$tab["description"]."</p>";
					echo "<p class='prix_min'>Prix minimum : ".$tab["prix"]." €</p>";
					echo "<hr/><br/>";
				}
			}else{
				if(isset($_GET['type'])){
					//on affiche tous les produits de ce type.
					$req='Select id_p ident,nom_p,description,prix From Produit NATURAL JOIN Tarif Where type="'.$_GET['type'].'" HAVING Prix <= ALL (SELECT prix From Tarif Where id_p=ident)';
					$res=execute_requete($req);
					foreach($res as $tab){
						echo "<p class='titreP'><a href='info_produit.php?id_p=".$tab["ident"]."' >".$tab["nom_p"]."</a></p>";
						echo "<p class='description'>description : ".$tab["description"]."</p>";
						echo "<p class='prix_min'>Prix minimum : ".$tab["prix"]." €</p>";
						echo "<hr/><br/>";
					}

				}else{
					//c'est une recherche.
					//vérification de la validité du formulaire précédent.
					if(empty($_POST["recherche"]) || (!isset($_POST["description"]) && !isset($_POST["nom"]) && !isset($_POST["reference"]))){
						echo "<p>L'un des champs de recherche est vide.<br/>".
						     "Veuillez compléter de nouveau le formulaire de recherche. </p>
						     <p>Attention : il faut que description, nom ou référence soit coché.</p>";
				
					}else{
						$recherche=htmlspecialchars($_POST['recherche']);
						echo "<p>Vous recherchez : ".$_POST["recherche"]."</p><hr/>";

						//initialisation des variables en vu de la requête finale
						//en fonction de la méthode de recherche de l'utilisateur.
						$desc='';
						$nom='';
						$ref='';

						//REGEXP [[:<:]] $recherche [[:>:]] permet de trouver le mot
						//cherché dans l'attribut spécifié.
	
						//si l'utilisateur a coché la case description :
						if(isset($_POST["description"])){
							$desc= 'or description REGEXP "[[:<:]]'.$recherche.'[[:>:]]"';
						}

						//si l'utilisateur a coché la case nom :
						if(isset($_POST["nom"])){
							$nom= 'or nom_p REGEXP "[[:<:]]'.$recherche.'[[:>:]]"';
						}
	
						//si l'utilisateur a coché la case reference :
						if(isset($_POST["reference"])){
							$ref= 'or ref REGEXP "[[:<:]]'.$recherche.'[[:>:]]"';
						}
				
						//on fait notre requête pour récupérer les produits recherchés par l'utilisateur.
						$req='Select id_p ident,nom_p,description,prix From Produit NATURAL JOIN Tarif Where 0 '.$desc.$nom.$ref.' HAVING Prix <= ALL (SELECT prix From Tarif Where id_p=ident)';
						$res=execute_requete($req);

						if(empty($res)){
							echo "<p>Aucun résultat.</p>";
						}else{
							
							foreach($res as $tab){
								echo "<p class='titreP'><a href='info_produit.php?id_p=".$tab["ident"]."' >".$tab["nom_p"]."</a></p>";
								echo "<p class='description'>description : ".$tab["description"]."</p>";
								echo "<p class='prix_min'>Prix minimum : ".$tab["prix"]." €</p>";
								echo "<hr/><br/>";
							}
	
						}
					}
				}//fin de la recherche
			}

			deconnection_base();


		?>
		

	</div>

	<?php include("php/foot.php"); ?>


</body>
</html>
