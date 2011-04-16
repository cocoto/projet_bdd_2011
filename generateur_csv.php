<?php
	if(isset($_GET['telecharger']))
	{
		header('Content-Disposition: attachment; filename="'.$_GET['telecharger'].'"');
		readfile($_GET['telecharger']);
		@unlink($_GET['telecharger']);
	}
	else
	{
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Generateur d'exportation</title>
	<link href="CSS/style.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<?php include("php/head.php"); ?>
	<?php include("php/menu.php"); ?>
	<?php include("php/fonctions.php"); ?>
	<div id='corps'>
	
		<h2>Génération de votre fichier....</h2>
		<?php
		//Générateur de CSV
		connection_base();
		if(isset($_SESSION['id_mag']))
		{
			$requete="SELECT Produit.id_p,ref, type, nom_p,dispo,prix 
				FROM Produit LEFT OUTER JOIN 
					(SELECT id_p,prix,dispo FROM Tarif WHERE id_mag=".$_SESSION['id_mag'].") test ON Produit.id_p = test.id_p 
				ORDER BY dispo DESC,type,nom_p";
			if($resultat=execute_requete($requete)){
				$nom_fichier="generator/tarif_".time().".csv";
				if ($fichier=@fopen($nom_fichier,"w"))
				{
					fwrite($fichier,"ne pas changer|type|nom du produit|référence|prix|disponibilité\r\n");
					foreach($resultat as $ligne)
					{
						
						$ajout=$ligne['id_p'].'|'.$ligne['type'].'|'.$ligne['nom_p'].'|';
						if (isset($ligne['ref']))
						{
							$ajout.=empty($ligne['ref'])?'':$ligne['ref'];
						}
						$ajout.='|';
						if (isset($ligne['prix']))
						{
							$ajout.=empty($ligne['prix'])?'':$ligne['prix'];
						}
						$ajout.='|';
						
						if(isset($ligne['dispo']))
						{
							$ajout.=$ligne['dispo']==1?'dispo':'';
						}
						$ajout.="| \n\r";
						fwrite($fichier,$ajout);	
					}
					echo '<p>Génération du fichier terminé, vous pouvez le récupèrer <a href="?telecharger='.$nom_fichier.'">ici</a></p>';
				}
				else
				{
					echo "<p>Impossible de creer/ouvrir le fichier</p>";
				}	
			}
			else
			{
				echo "<p>Requete echouee</p>";
			}
			deconnection_base();
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
<?php } ?>
