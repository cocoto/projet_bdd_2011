<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Comparateur de prix</title>
	<link href="CSS/style.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
	<?php include("php/head.php"); ?>
	<?php include("php/menu.php"); ?>
	<?php include("php/fonctions.php"); ?>
	<div id='corps'>
	<?php
		if(connection_base())
		{
			if(isset($_GET['id_p']))
			{
				$requete='SELECT ref,nom_p,type,description FROM Produit WHERE id_p="'.$_GET['id_p'].'"';
				if($resultat=execute_requete($requete))
				{
					echo "<h2>".$resultat[0]['nom_p']."</h2>";
					echo "<h3>".$resultat[0]['description']."</h3>";
					$requete='SELECT nom_ens,nom_m,ville,taille,prix,dispo FROM Tarif NATURAL JOIN Magasin JOIN Enseigne on Magasin.id_ens=Enseigne.id_ens WHERE id_p="'.$_GET['id_p'].'" ORDER BY dispo DESC, prix ASC';
					if ($resultat=execute_requete($requete))
					{
						echo '<table class="table_prix"><th>Enseigne</th><th>Magasin</th><th>Ville</th><th>prix</th><th>disponibilité</th>';
						foreach($resultat as $ligne)
						{
							$dispo=$ligne['dispo']==1?"oui":"non";
							echo '<tr><td>'.$ligne['nom_ens'].'</td><td>'.$ligne['nom_m'].'</td><td>'.$ligne['ville'].'</td><td>'.$ligne['prix'].'</td><td>'.$dispo.'</td></tr>';
						}
						echo"</table>";
					}
					else
					{
						echo "Produits indisponibles";
					}
				}
				else
				{
					# code...
					echo "Votre produit est introuvable dans notre base de donnée";
				}
			}
			else
			{
				echo 'Vous n\' avez pas selectioné de produit';
				echo '<script language="JavaScript">history.back()</script>';
			}
		}
		else
		{
			echo "Problème de connection à la base de donnée, merci de revenir plus tard ou de contacter un administrateur";
		}
	?>
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
