<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Comparateur de prix</title>
	<link href="CSS/style.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
	<?php include("php/head.php"); ?>
	<?php include("php/menu.php"); ?>
	<?php include("php/fonctions.php"); ?>
	<div id='corps'>
	<h1>Liste des produits :</h1>
	<?php	
		if (connection_base())
		{
			if (isset($_SESSION['id_mag']))
			{
				if(isset($_post['id_p']))
				{
					$prix=htmlspecialchars($_post['prix']);
					$dispo=isset($_post['dispo'])?1:0;
					$requete='REPLACE INTO Tarif(id_p,id_mag,prix,dispo) VALUES ("'.$_post['id_p'].'","'.$_SESSION['id_mag'].'","'.$prix.'","'.$dispo.'")';
					if(execute_requete($requete))
					{
						echo "Modifications effectuées";
					}
					else
					{
						echo "Problème lors des modifications";
					}
				}
				echo"<table><th>Nom du produit</th><th>Catégorie</th><th>Prix</th><th>Disponibilité</th>";
				$requete="SELECT Produit.id_p, type, nom_p,dispo,prix FROM Produit LEFT OUTER JOIN (SELECT id_p,prix,dispo FROM Tarif WHERE id_mag=".$_SESSION['id_mag'].") test ON Produit.id_p = test.id_p ORDER BY dispo DESC,type,nom_p";
				$tab_resultat=execute_requete($requete);
				foreach ($tab_resultat as $ligne)
				{
					if (!$ligne['prix'])
					{
						$prix=0;
					}
					$dispo = $ligne['dispo']? "checked":"";
					echo '<tr><form action="" method="post"><input type="hidden" name="id_p" value="'.$ligne['id_p'].'"/><td><label for="'.$ligne['id_p'].'">'.$ligne['nom_p'].'</label></td><td>'.$ligne['type'].'</td><td><input type="text" name="prix" value="'.$ligne['prix'].'" id="'.$ligne['id_p'].'"/></td><td><input type="checkbox" name="dispo" '.$dispo.'/></td><td><input type="submit" value="valider"/></tr></form>';
				}
				echo '</table>';
			}
			else
			{
				echo "Vous n'avez pas les droits pour accèder à cette page";
			}
		}
		else
		{
			echo "Problème lors de la connection à la base de donnée. Veuillez contactez un administrateur";
		}
		
	?>
	</div>
	<?php
		#include('php/foot.php');
		deconnection_base() ;
	?>
</body>

</html> 
