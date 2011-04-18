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
	<?php
		if(connection_base())
		{
			if(isset($_GET['id_p']))
			{
				$requete='SELECT ref,nom_p,type,rayon,description FROM Produit NATURAL JOIN Type WHERE id_p="'.$_GET['id_p'].'"';
				if($resultat=execute_requete($requete))
				{
					echo "<p id='chemin'><a href='resultat.php?rayon=".$resultat[0]['rayon']."'>".$resultat[0]['rayon']."</a>/<a href='resultat.php?type=".$resultat[0]['type']."'>".$resultat[0]['type']."</a>/".$resultat[0]['nom_p']."</p>";
					echo "<p class='titreP'>".$resultat[0]['nom_p']."</p>";
					echo "<p class='description'>".$resultat[0]['description']."</p><br/></br></br></br></br>";
					$requete='SELECT nom_ens,nom_m,ville,taille,prix,dispo FROM Tarif NATURAL JOIN Magasin JOIN Enseigne on Magasin.id_ens=Enseigne.id_ens WHERE id_p="'.$_GET['id_p'].'" ORDER BY dispo DESC, prix ASC';
					if ($resultat=execute_requete($requete))
					{
						echo '<div id="table_prix"><table id=\'ttable_prix\'><tr><th class="tdtable_prix">Enseigne</th><th class="tdtable_prix">Magasin</th><th class="tdtable_prix">Ville</th><th class="tdtable_prix">prix</th><th class="tdtable_prix">disponibilité</th></tr>';
						foreach($resultat as $ligne)
						{
							$dispo=$ligne['dispo']==1?"oui":"non";
							echo '<tr><td class="tdtable_prix">'.$ligne['nom_ens'].'</td><td class="tdtable_prix">'.$ligne['nom_m'].'</td><td class="tdtable_prix">'.$ligne['ville'].'</td><td class="tdtable_prix">'.$ligne['prix'].'</td><td class="tdtable_prix">'.$dispo.'</td></tr>';
						}
						echo"</table></div>";
					}
					else
					{
						echo "Produits indisponibles";
					}
				}
				else
				{
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
