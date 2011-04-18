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
			if (isset($_SESSION['id_ens']) || isset($_SESSION['admin']))
			{
				if(isset($_POST['id_p']) && $_POST['type']!='defaut')
				{
					if(isset($_POST['supp_produit']) and $_POST['supp_produit']=="on")
					{
						$requete='DELETE FROM Tarif WHERE id_p="'.$_POST['id_p'].'"';
						if(execute_requete($requete))
						{
							$requete='DELETE FROM Produit WHERE id_p="'.$_POST['id_p'].'"';
						}
						else
						{
							echo "Erreur sur la supression des tarifs liés à votre produit";
						}
					}
					else
					{
						$requete='REPLACE INTO Produit(id_p,ref,type,nom_p,description) VALUES ("'.$_POST['id_p'].'","'.htmlspecialchars($_POST['ref']).'","'.$_POST['type'].'","'.htmlspecialchars($_POST['nom_p']).'","'.htmlspecialchars($_POST['description']).'")';	
					}

					if(execute_requete($requete))
					{
						echo "Modifications effectuées";
					}
					else
					{
						echo "Problème lors des modifications";
					}
				}
				$tab_types=execute_requete('SELECT type FROM Type');
				echo"<br/>Ajouter un produit<br/>";
				echo '<form action="" method="post"><p class="ligne"><input type="hidden" name="id_p" value=""/><span class="colone"><input type="text" name="ref" value="Référence"/></span><span class="colone"><input type="text" name="nom_p" value="nom du produit"/></span><span class="colone"><select name="type"><option value=\'defaut\'>Choisir un type</option>';
					foreach($tab_types as $type)
					{
						echo '<option value="'.$type['type'].'">'.$type['type'].'</option>';
					}
					echo '</select></span><span class="colone"><input type="text" name="description" value="Description"/></span><span class="colone"><input type="submit" value="valider"/></span></p></form>';
				echo '<br/><br/>';
				$requete="SELECT Produit.id_p,ref, type, nom_p,description FROM Produit ORDER BY type,nom_p";
				$tab_resultat=execute_requete($requete);
				foreach ($tab_resultat as $ligne)
				{
					echo '<form action="" method="post"><p class="ligne"><input type="hidden" name="id_p" value="'.$ligne['id_p'].'"/><span class="colone"><input type="text" name="ref" value="'.$ligne['ref'].'"/></span><span class="colone"><input type="text" name="nom_p" value="'.$ligne['nom_p'].'"/></span><span class="colone"><select name="type">';
					foreach($tab_types as $type)
					{
						$coche=$ligne['type']==$type['type']?'selected="selected"':'';
						echo '<option value="'.$type['type'].'" '.$coche.'>'.$type['type'].'</option>';
					}
					echo '</select></span><span class="colone"><input type="text" name="description" value="'.$ligne['description'].'"/></span><span class="colone"><input type="checkbox" name="supp_produit"/></span><span class="colone"><input type="submit" value="valider"/></span></p></form>';
				}
			}
			else
			{
				echo "Merci de vous connecter pour atteindre cette partie du site";
				include("php/login.php");
			}
		}
		else
		{
			echo "Vous n'avez pas les droits pour accèder à cette page";
		}
		
	?>
	</div>
	<?php
		include('php/foot.php');
		deconnection_base() ;
	?>
</body>

</html> 
