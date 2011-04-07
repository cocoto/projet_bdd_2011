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
			//@TODO Faire la gestion des différents droits
			//@TODO Implementer Javascript pour vérifier les champs + AJAX dans les listes
			if(isset($_SESSION['id_mag'])||isset($_SESSION['id_ens']))
			{
				if(connection_base())
				{
					echo'<h2>Modifier / Ajouter une enseigne</h2>';
					if(isset($_POST['nom_ens']))
					{
						if(!empty($_POST['nom_ens'])&&!empty($_POST['dirg_ens'])&&!empty($_POST['pass_ens']))
						{
							$nom=htmlspecialchars($_POST['nom_ens']);
							$dirg_ens=htmlspecialchars($_POST['dirg_ens']);
							$mdp=empty($_POST['pass_ens'])?"":sha1(htmlspecialchars($_POST['pass_ens']));
							$requete='REPLACE INTO Enseigne(id_ens,nom_ens,nom_dirg,mdp) VALUES("'.$_POST['id_ens'].'","'.$nom.'","'.$dirg_ens.'","'.$mdp.'")';
							if(execute_requete($requete))
							{
								echo "Modifications effectuées avec succès !";
							}
							else
							{
								echo "Problème lors de la modification, merci de renseigner tous les champs";
							}
						}
						else
						{
							echo "Vous n'avez pas remplis tous les champs";
						}
					}
					$requete='SELECT id_ens,nom_ens FROM Enseigne';
					if($resultat_ens=execute_requete($requete))
					{
						echo '<form action="" method=POST><select name="id_ens" onchange="submit()"><OPTION>Choisir Enseigne</OPTION>';
						foreach($resultat_ens as $enseigne)
						{
							echo'<OPTION VALUE="'.$enseigne['id_ens'].'">'.$enseigne['nom_ens'].'</OPTION>';
						}
						echo '</select></form>';
					}
					$nom="";
					$nom_dirg="";
					$valid="Ajouter";
					$id_ens="";
					if(isset($_POST['id_ens']))
					{
						$requete='SELECT nom_ens,nom_dirg FROM Enseigne WHERE id_ens="'.$_POST['id_ens'].'"';
						if($resultat=execute_requete($requete))
						{
							$nom=$resultat[0]['nom_ens'];
							$nom_dirg=$resultat[0]['nom_dirg'];
							$valid="Modifier";
							$id_ens=$_POST['id_ens'];
						}
					}
					echo '<form action="" method=POST><input type="hidden" name="id_ens" value="'.$id_ens.'"/><table>
						<tr>
							<td><label for="nom_ens">Nom de l\'enseigne :</label></td>
							<td><input type="text" name="nom_ens" id="nom_ens" value="'.$nom.'"/></td>
						</tr>
						<tr>
							<td><label for="dirg_ens">Nom du dirigeant :</label></td>
							<td><input type="text" name="dirg_ens" id="dirg_ens" value="'.$nom_dirg.'"/></td>
						</tr>
						<tr>
							<td><label for="pass_ens">Mot de Passe :</label></td>
							<td><input type="password" name="pass_ens" id="pass_ens"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"</td>
						</tr></table></form>';
				
				
					echo'<h2>Modifier / Ajouter un magasin</h2>';
					if(isset($_POST['nom_mag']))
					{
						if(!empty($_POST['nom_mag'])&&!empty($_POST['dirg_mag'])&&!empty($_POST['ville_mag'])&&!empty($_POST['pass_mag'])&&!empty($_POST['ens_mag'])&&!empty($_POST['taille_mag']))
						{
							$nom=htmlspecialchars($_POST['nom_mag']);
							$dirg_ens=htmlspecialchars($_POST['dirg_mag']);
							$ville=htmlspecialchars($_POST['ville_mag']);
							$ens=$_POST['ens_mag'];
							$taille=$_POST['taille_mag'];
							$mdp=sha1(htmlspecialchars($_POST['pass_mag']));
							$requete='REPLACE INTO Magasin(id_mag,nom_m,nom_resp,taille,ville,id_ens,mdp) VALUES("'.$_POST['id_mag'].'","'.$nom.'","'.$dirg_ens.'","'.$taille.'","'.$ville.'","'.$ens.'","'.$mdp.'")';
							echo $requete;
							if(execute_requete($requete))
							{
								echo "Modifications effectuées avec succès !";
							}
							else
							{
								echo "Problème lors de la modification, merci de renseigner tous les champs";
							}
						}
						else
						{
							echo "Vous n'avez pas remplis tous les champs";
						}
					}
					$requete='SELECT id_mag,nom_m,nom_ens FROM Magasin JOIN Enseigne on Enseigne.id_ens=Magasin.id_ens';
					if($resultat=execute_requete($requete))
					{
						echo '<form action="" method=POST><select name="id_mag" onchange="submit()"><OPTION>Choisir Magasin</OPTION>';
						foreach($resultat as $magasin)
						{
							echo'<OPTION VALUE="'.$magasin['id_mag'].'">'.$magasin['nom_ens'].' '.$magasin['nom_m'].'</OPTION>';
						}
						echo '</select></form>';
					}
					$nom="";
					$nom_resp="";
					$taille="";
					$valid="Ajouter";
					$id_ens="";
					$ville="";
					$id_mag="";
					if(isset($_POST['id_mag']))
					{
						$requete='SELECT nom_m,nom_resp,taille,ville,id_ens FROM Magasin WHERE id_mag="'.$_POST['id_mag'].'"';
						if($resultat=execute_requete($requete))
						{
							$nom=$resultat[0]['nom_m'];
							$nom_resp=$resultat[0]['nom_resp'];
							$valid="Modifier";
							$id_ens=$resultat[0]['id_ens'];
							$taille=$resultat[0]['taille'];
							$ville=$resultat[0]['ville'];
							$id_mag=$_POST['id_mag'];
						}
					}
					echo '<form action="" method=POST><input type="hidden" name="id_mag" value="'.$id_mag.'"/><table>
						<tr>
							<td><label for="nom_mag">Nom du magasin :</label></td>
							<td><input type="text" name="nom_mag" id="nom_mag" value="'.$nom.'"/></td>
						</tr>
						<tr>
							<td><label for="dirg_mag">Nom du dirigeant :</label></td>
							<td><input type="text" name="dirg_mag" id="dirg_mag" value="'.$nom_resp.'"/></td>
						</tr>
						<tr>
							<td><label for="ville_mag">Ville :</label></td>
							<td><input type="text" name="ville_mag" id="ville_mag" value="'.$ville.'"/></td>
						</tr>
						<tr>
							<td><label for="ens_mag">Enseigne :</label></td>
							<td><select name="ens_mag"><OPTION>"Choisir une enseigne"</OPTION>'; 
								foreach($resultat_ens as $enseigne)
								{
									echo'<OPTION VALUE="'.$enseigne['id_ens'].'"';
									if($enseigne['id_ens']==$id_ens){echo'selected="selected"';}
									echo '>'.$enseigne['nom_ens'].'</OPTION>';
								}
								echo'</td></select>
						</tr>
						<tr>
							<td><label for="ens_mag">Enseigne :</label></td>
							<td><select name="taille_mag"><OPTION>"Taille du magasin"</OPTION>'; 
									echo'<OPTION VALUE="1"';
									if($taille==1){echo'selected="selected"';}
									echo '>Épicerie</OPTION>';
									echo'<OPTION VALUE="2"';
									if($taille==2){echo'selected="selected"';}
									echo '>Petit Magasin</OPTION>';
									echo'<OPTION VALUE="3"';
									if($taille==3){echo'selected="selected"';}
									echo '>Supermarché</OPTION>';
									echo'<OPTION VALUE="4"';
									if($taille==4){echo'selected="selected"';}
									echo '>Hypermarché</OPTION>';
								echo'</td></select>
						</tr>
						<tr>
							<td><label for="pass_mag">Mot de Passe :</label></td>
							<td><input type="password" name="pass_mag" id="pass_mag"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"</td>
						</tr></table></form>';
				}
				else
				{
					echo "Problème de connection à la base de donnée, merci de revenir plus tard ou de contacter un administrateur";
				}
			}
			else
			{
				echo "Vous n'avez pas les droits pour accèder à cette page";
			}
		?>
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
