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
			//SEUL UN magasin peut accèder à cette page
			if (isset($_SESSION['id_mag']))
			{
				//Traitement de la modification d'un produit individuel
				if(isset($_POST['id_p']))
				{
					$prix=htmlspecialchars($_POST['prix']);
					$dispo=isset($_POST['dispo'])?1:0;
					$requete='REPLACE INTO Tarif(id_p,id_mag,prix,dispo) VALUES ("'.$_POST['id_p'].'","'.$_SESSION['id_mag'].'","'.$prix.'","'.$dispo.'")';
					if(execute_requete($requete))
					{
						echo "Modifications effectuées";
					}
					else
					{
						echo "Problème lors des modifications";
					}
				}?>
				<div class='nouveau'><b><span class="souligne">NOUVEAU : modification rapide de vos tarifs :</span></b><br/>
					<a href="generateur_csv.php">&#151;&gt; Téléchargez votre grille tarifaire &lt;&#151;</a>
					<form action="upload_prix.php" method="post" enctype="multipart/form-data">
						<p>
								Envoyez votre fichier complété :
								<input type="file" name="fichier" />
								<input type="submit" value="Envoyer le fichier" />
						</p>
					</form>
				</div>
				<?php
				//echo"<table><th>Nom du produit</th><th>Catégorie</th><th>Prix</th><th>Disponibilité</th>";
				//On selectionne et affiche l'ensemble des produits du site, qu'ils soient ou non dans le magasin, et on affiche les tarifs et la dispo de chacun
				$requete="SELECT Produit.id_p, type, nom_p,dispo,prix FROM Produit LEFT OUTER JOIN (SELECT id_p,prix,dispo FROM Tarif WHERE id_mag=".$_SESSION['id_mag'].") test ON Produit.id_p = test.id_p ORDER BY dispo DESC,type,nom_p";
				$tab_resultat=execute_requete($requete);
				/** La norme W3C interdit la présence d'un formulaire dans un tableau
				 * Le code est basé sur un "tableau de formulaire", et ensuite a été converti en jeux de paragraphes et <span>
				 */
				foreach ($tab_resultat as $ligne)
				{
					if (!$ligne['prix'])
					{
						$prix=0;
					}
					$dispo = $ligne['dispo']? 'checked="checked"':'';
					echo '<form action="" method="post"><p class="ligne"><input type="hidden" name="id_p" value="'.$ligne['id_p'].'"/><span class="colone_g"><label for="prix_'.$ligne['id_p'].'">'.$ligne['nom_p'].'</label></span><span class="colone_p">'.$ligne['type'].'</span><span class="colone_p"><input type="text" class="form_prix" name="prix" value="'.$ligne['prix'].'" id="prix_'.$ligne['id_p'].'"/></span><span class="colone_p"><input type="checkbox" name="dispo" '.$dispo.'/></span><span class="colone_p"><input type="submit" value="valider"/></span></p><p class="ligne"></p><hr/></form>';
				}
				//echo '</table>';
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
