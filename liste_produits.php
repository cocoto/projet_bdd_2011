<?php
	include('php/fonctions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Accueil</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
	<?php
		#include('php/head.php');
		#include('php/menu.php');
		session_start();
		$_SESSION['id_mag']=2;
	?>
	<div id="corps">
	<h1>Liste des produits :</h1>
	<?php
		if (isset($_SESSION['id_mag']))
		{
			if (connection_base())
			{
				echo"<table>";
				$requete="SELECT Produit.id_p, type, nom_p,dispo,prix FROM Produit LEFT OUTER JOIN (SELECT id_p,prix,dispo FROM Tarif WHERE id_mag=".$_SESSION['id_mag'].") test ON Produit.id_p = test.id_p ORDER BY dispo DESC,type,nom_p";
				$tab_resultat=execute_requete($requete);
				foreach ($tab_resultat as $ligne)
				{
					if (!$ligne['prix'])
					{
						$prix=0;
					}
					$dispo = $ligne['dispo']? "checked":"";
					echo '<form action="" method=POST><input type="hidden" id="id_p"/><tr><td>'.$ligne['nom_p'].'</td><td>'.$ligne['type'].'</td><td><input type="text" id="prix" value="'.$ligne['prix'].'"/></td><td><input type="checkbox" id="prix" '.$dispo.'/></td><td><input type="submit" value="valider"/></tr>';
					//@TODO Trouver le moyen de faire une centaine de formulaire et n'evoyer que les modifications...
				}
				echo '</table>';
			}
			else
			{
				echo "Problème lors de la connection à la base de donnée. Veuillez contactez un administrateur";
			}	
		}
		
	?>
	</div>
	<?php
		#include('php/foot.php');
		deconnection_base() ;
	?>
</body>

</html> 
