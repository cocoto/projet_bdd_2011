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
		if(isset($_SESSION['id_mag']))
		{
			if(isset($_FILES['fichier']) && $_FILES['fichier']['type']=="text/csv" && $_FILES['fichier']['error']==0)
			{
				if(connection_base())
				{
					if($fichier=fopen($_FILES['fichier']['tmp_name'],"r"))
					{
						while($ligne = fgets($fichier))
						{
							$tab=preg_split('#\|#', $ligne); //Explosion d'une des ligne selon le délimiteur |
							if(!empty($tab[4]) && is_numeric($tab[0]))
							{
								$dispo=($tab[5]=="dispo")?"1":"0";
								$requete='INSERT IGNORE INTO Tarif(id_p,id_mag,prix,dispo) VALUES("'.$tab[0].'","'.$_SESSION['id_mag'].'","'.$tab['4'].'","'.$dispo.'")';
								execute_requete($requete);
							}
						}
						echo "<p>L'ensemble de vos tarifs ont étés mis à jour, vous pouvez continuer votre navigation</p>";
					}
					else
					{
						echo "impossible d'ouvrir votre fichier !";
					}
				}
				else
				{
					echo "impossible d'accèder à la base de donnée";
				}
				deconnection_base();
			}
		}
		else
		{
			echo "<p>Vous n'avez pas les droits pour accèder à cette page</p>";
		}
		
		?>
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
