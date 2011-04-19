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
			/**
			 * Cette page est destinée à l'administration générale du site (Rayon, Types, Produits, Magasins, Enseignes)
			 * Seul l'administrateur du site peut y accèder
			 * La première partie du code gère les modifications envoyées par formulaire
			 * La seconde partie traite de la création des formulaires (qui prennent de fait les modifications effectuées)
			 * 
			 * ATTENTON=================================================================
			 * La suppression d'une enseigne entraine la suppression des magasins associés
			 * La suppression d'un magasin entraine la suppression des tarifs associés
			 * La suppression d'un rayon entraine la suppression des catégories associées
			 * La suppression d'une catégorie entraine la suppression des produits associés
			 * La suppression d'un produit entraine la suppression des tarifs associés 
			 * ==========================================================================
			 * Les mots de passes sont encryptés en sha1
			 */
			 
			//@TODO Faire la gestion des différents droits
			//@TODO Implementer Javascript pour vérifier les champs + AJAX dans les listes
			if(isset($_SESSION['admin'])) //Seul l'administrateur peut accèder à la page'
			{
				if(connection_base())
				{
					echo '<a href="admin_produits.php">Administration des produits</a><br/>';
					if(isset($_POST['nom_ens']))
					{
						
						/*Traitement des données une fois le formulaire d'enseigne envoyé*/
						if(!empty($_POST['nom_ens'])&&!empty($_POST['dirg_ens'])&&!empty($_POST['pass_ens']))
						{
							//Si la suppression est demandée
							if(isset($_POST['supp_ens'])&&$_POST['supp_ens']=="on")
							{
								$requete='DELETE FROM Tarif WHERE id_mag in (SELECT id_mag FROM Magasin WHERE id_ens="'.$_POST['id_ens'].'")';
								//On supprime les tarifs des magasins liés à l'enseigne
								if(execute_requete($requete))
								{
									$requete='DELETE FROM Enseigne, Magasin USING Enseigne LEFT OUTER JOIN Magasin on Magasin.id_ens=Enseigne.id_ens WHERE Enseigne.id_ens="'.$_POST['id_ens'].'"';
								}
								else
								{
									echo "problème lors de la suppression, veuillez contacter un administrateur";
								}
							}
							//Si c'est un ajout/modification
							else
							{
								$nom=htmlspecialchars($_POST['nom_ens']);
								$dirg_ens=htmlspecialchars($_POST['dirg_ens']);
								$mdp=empty($_POST['pass_ens'])?"":sha1(htmlspecialchars($_POST['pass_ens']));
								$requete='REPLACE INTO Enseigne(id_ens,nom_ens,nom_dirg,mdp) valueS("'.$_POST['id_ens'].'","'.$nom.'","'.$dirg_ens.'","'.$mdp.'")';
								
							}
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
					if(isset($_POST['nom_mag']))
					{
						/*Traitement des données une fois le formulaire de magasin envoyé*/
						if(!empty($_POST['nom_mag'])&&!empty($_POST['dirg_mag'])&&!empty($_POST['ville_mag'])&&!empty($_POST['pass_mag'])&&!empty($_POST['ens_mag'])&&!empty($_POST['taille_mag']))
						{
							if(isset($_POST['supp_mag'])&&$_POST['supp_mag']=="on")
							{
								//On supprime le magasin et l'ensemble des tarifs associés
								$requete='DELETE FROM Magasin, Tarif USING Magasin LEFT OUTER JOIN Tarif on Tarif.id_mag=Magasin.id_mag WHERE Magasin.id_mag="'.$_POST['id_mag'].'"';
							}
							else
							{
								$nom=htmlspecialchars($_POST['nom_mag']);
								$dirg_ens=htmlspecialchars($_POST['dirg_mag']);
								$ville=htmlspecialchars($_POST['ville_mag']);
								$ens=$_POST['ens_mag'];
								$taille=$_POST['taille_mag'];
								$mdp=sha1(htmlspecialchars($_POST['pass_mag'])); //Encodage du mot de passe
								$requete='REPLACE INTO Magasin(id_mag,nom_m,nom_resp,taille,ville,id_ens,mdp) valueS("'.$_POST['id_mag'].'","'.$nom.'","'.$dirg_ens.'","'.$taille.'","'.$ville.'","'.$ens.'","'.$mdp.'")';	
							}
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
					
					if(isset($_POST['nom_rayon']) && !empty($_POST['nom_rayon']))
					{
						/*Traitement des données une fois le formulaire de rayon envoyé*/
						if(isset($_POST['supp_rayon']) && $_POST['supp_rayon']=="on")
							{
								//On supprime les tarifs liés aux produits dont les catégories sont concernées par le rayon
								$requete='DELETE FROM Tarif
								WHERE Tarif.id_p in (SELECT id_p FROM Produit WHERE type in (SELECT type FROM Type WHERE rayon="'.$_POST['nom_rayon'].'"))';
								if(execute_requete($requete))
								{
									//Puis on supprime les produits en question
									$requete='DELETE FROM Produit WHERE type in (SELECT type FROM Type WHERE rayon="'.$_POST['nom_rayon'].'")';
									if (execute_requete($requete))
									{
										//Avant de supprimer tous les types liés à ce rayon (et le rayon indirectement)
										$requete='DELETE FROM Type Where Rayon="'.$_POST['nom_rayon'].'"';
									}
									else
									{
										echo "problème lors de la suppression, veuillez contacter un administrateur";
									}
								}
								else
								{
									echo "problème lors de la suppression, veuillez contacter un administrateur";
									
								}
								//execute_requete($requete);
							}
							else
							{
								$nom=htmlspecialchars($_POST['nom_rayon']);
								$requete='UPDATE Type
										SET Type.rayon="'.$nom.'" WHERE Type.rayon="'.$_POST['nom_rayon_ans'].'"';
							}
							if(execute_requete($requete))
							{
								echo "Modifications effectuées avec succès !";
							}
							else
							{
								echo "Problème lors de la modification, merci de renseigner tous les champs";
							}
					}
					if(isset($_POST['nom_type']))
					{
						/*Traitement des données une fois le formulaire de type envoyé*/
						if(!empty($_POST['nom_type']) && isset($_POST['nom_trayon']) && !empty($_POST['nom_trayon']))
						{
							if(isset($_POST['supp_type']) && $_POST['supp_type']=="on")
							{
								//On supprime les tarifs du type à supprimer et le type donné
								$requete='DELETE Tarif,Type FROM Tarif,Produit,Type
								WHERE Type.type="'.$_POST['nom_type_ans'].'" AND Tarif.id_p in
								(SELECT id_p FROM Produit WHERE type="'.$_POST['nom_type_ans'].'")';
								if(execute_requete($requete))
								{
									//On retire les produits liés au type
									$requete='DELETE FROM Produit WHERE type="'.$_POST['nom_type_ans'].'"';
								}
								else
								{
									echo "problème lors de la suppression, veuillez contacter un administrateur";
								}
								//execute_requete($requete);
							}
							else
							{
								$nom=htmlspecialchars($_POST['nom_type']);
								$rayon=htmlspecialchars(empty($_POST['ajout_rayon'])?$_POST['nom_trayon']:$_POST['ajout_rayon']);
								$requete='UPDATE Type,Produit 
										SET Type.type="'.$nom.'",Type.rayon="'.$rayon.'",Produit.type="'.$nom.'" 
											WHERE Type.type="'.$_POST['nom_type_ans'].'" and Produit.type="'.$_POST['nom_type_ans'].'"';
								if(execute_requete($requete))
								{
									$requete='REPLACE INTO Type(type,rayon) valueS("'.$nom.'","'.$rayon.'")';
								}
							}
							if(execute_requete($requete))
							{
								if(execute_requete($requete))
								{
									echo "Modifications effectuées avec succès !";
								}
								else
								{
									echo "Erreur critique #1, merci de contacter un administrateur en detaillant votre démarche";
								}
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
		
		/*Menu traditionnel d'édition des différentes catégories'*/
		
		
		//PARTIE ENSEIGNE
		echo'<h2 id="edit_enseigne">Modifier / Ajouter une enseigne</h2>';
					$requete='SELECT id_ens,nom_ens FROM Enseigne';
					if($resultat_ens=execute_requete($requete))
					{
						echo '<form action="#edit_enseigne" method="post"><p><select name="id_ens" onchange="submit()"><option>Choisir Enseigne</option>';
						foreach($resultat_ens as $enseigne)
						{
							echo'<option value="'.$enseigne['id_ens'].'">'.$enseigne['nom_ens'].'</option>';
						}
						echo '</select></p></form>';
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
					echo '<form action="" method="post"><p><input type="hidden" name="id_ens" value="'.$id_ens.'"/></p><table>
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
							<td><label for="supp_ens">Supprimer :</label></td>
							<td><input type="checkbox" name="supp_ens" id="supp_ens"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"/></td>
						</tr></table></form>';
				
		
		
		//PARTIE MAGASIN		
		echo'<h2 id="edit_magasin">Modifier / Ajouter un magasin</h2>';
					
					$requete='SELECT id_mag,nom_m,nom_ens FROM Magasin JOIN Enseigne on Enseigne.id_ens=Magasin.id_ens';
					if($resultat=execute_requete($requete))
					{
						echo '<form action="#edit_magasin" method="post"><p><select name="id_mag" onchange="submit()"><option>Choisir Magasin</option>';
						foreach($resultat as $magasin)
						{
							echo'<option value="'.$magasin['id_mag'].'">'.$magasin['nom_ens'].' '.$magasin['nom_m'].'</option>';
						}
						echo '</select></p></form>';
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
					echo '<form action="" method="post"><p><input type="hidden" name="id_mag" value="'.$id_mag.'"/></p><table>
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
							<td><select name="ens_mag" id="ens_mag" ><option>Choisir une enseigne</option>'; 
								foreach($resultat_ens as $enseigne)
								{
									echo'<option value="'.$enseigne['id_ens'].'" ';
									if($enseigne['id_ens']==$id_ens){echo'selected="selected"';}
									echo '>'.$enseigne['nom_ens'].'</option>';
								}
								echo'</select></td>
						</tr>
						<tr>
							<td><label for="taille_mag">Taille du magasin :</label></td>
							<td><select name="taille_mag" id="taille_mag"><option>Taille du magasin</option>'; 
									echo'<option value="1" ';
									if($taille==1){echo'selected="selected"';}
									echo '>Épicerie</option>';
									echo'<option value="2" ';
									if($taille==2){echo'selected="selected"';}
									echo '>Petit Magasin</option>';
									echo'<option value="3" ';
									if($taille==3){echo'selected="selected"';}
									echo '>Supermarché</option>';
									echo'<option value="4" ';
									if($taille==4){echo'selected="selected"';}
									echo '>Hypermarché</option>';
								echo'</select></td>
						</tr>
						<tr>
							<td><label for="pass_mag">Mot de Passe :</label></td>
							<td><input type="password" name="pass_mag" id="pass_mag"/></td>
						</tr>
						<tr>
							<td><label for="supp_mag">Supprimer :</label></td>
							<td><input type="checkbox" name="supp_mag" id="supp_mag"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"/></td>
						</tr></table></form>';
						
						
						
		//PARTIE RAYON
		echo'<h2 id="modif_rayon">Modifier / Ajouter un rayon</h2>';
					$requete='SELECT DISTINCT rayon FROM Type';
					if($resultat_rayon=execute_requete($requete))
					{
						echo '<form action="#modif_rayon" method="post"><p><select name="nom_rayon_ans" onchange="submit()"><option>Choisir Rayon</option>';
						foreach($resultat_rayon as $rayon)
						{
							echo'<option value="'.$rayon['rayon'].'">'.$rayon['rayon'].'</option>';
						}
						echo '</select></p></form>';
					}
					if(isset($_POST['nom_rayon_ans']) && !empty($_POST['nom_rayon_ans']))
					{
						$requete='SELECT rayon FROM Type WHERE rayon="'.$_POST['nom_rayon_ans'].'"';
						if($resultat=execute_requete($requete))
						{
							$nom_ans=$resultat[0]['rayon'];
							$nom=$resultat[0]['rayon'];
							$valid="Modifier";
						}
						echo '<form action="" method="post"><p><input type="hidden" name="nom_rayon_ans" value="'.$nom_ans.'"/></p><table>
						<tr>
							<td><label for="nom_rayon">Nom :</label></td>
							<td><input type="text" name="nom_rayon" id="nom_rayon" value="'.$nom.'"/></td>
						</tr>
						<tr>
							<td><label for="supp_rayon">Supprimer :</label></td>
							<td><input type="checkbox" name="supp_rayon" id="supp_rayon"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"/></td>
						</tr></table></form>';
					}
					
		
		//PARTIE TYPE DE PRODUIT	
		echo'<h2 id="modif_type">Modifier / Ajouter un type de produit</h2>';
					
					$requete='SELECT type,rayon FROM Type';
					if($resultat=execute_requete($requete))
					{
						echo '<form action="#modif_type" method="post"><p><select name="nom_type_ans" onchange="submit()"><option>Choisir Type</option>';
						foreach($resultat as $type)
						{
							echo'<option value="'.$type['type'].'">'.$type['type'].'</option>';
						}
						echo '</select></p></form>';
					}
					$nom_ans="";
					$nom="";
					$rayon="";
					$valid="Ajouter";
					if(isset($_POST['nom_type_ans']))
					{
						$requete='SELECT type,rayon FROM Type WHERE type="'.$_POST['nom_type_ans'].'"';
						if($resultat=execute_requete($requete))
						{
							$nom_ans=$resultat[0]['type'];
							$nom=$resultat[0]['type'];
							$rayon=$resultat[0]['rayon'];
							$valid="Modifier";
						}
					}
					echo '<form action="" method="post"><p><input type="hidden" name="nom_type_ans" value="'.$nom_ans.'"/></p><table>
						<tr>
							<td><label for="nom_type">Nom :</label></td>
							<td><input type="text" name="nom_type" id="nom_type" value="'.$nom.'"/></td>
						</tr>
						<tr>
							<td>Rayon :</td><td>';
								$i=0;
								foreach($resultat_rayon as $l_rayon)
								{
									echo'<input type="radio" name="nom_trayon" id="trayon_'.$i.'" value="'.$l_rayon['rayon'].'"';
									if($l_rayon['rayon']==$rayon){echo' checked="checked"';}
									echo '/><label for="trayon_'.$i.'">'.$l_rayon['rayon'].'</label>';
									$i++;
								}

								echo'</td>
						</tr>
						<tr>
							<td><label for="ajout_rayon">Ou ajouter un rayon :</label></td>
							<td><input type="text" name="ajout_rayon" id="ajout_rayon" value=""/></td>
						</tr>
						<tr>
							<td><label for="supp_type">Supprimer :</label></td>
							<td><input type="checkbox" name="supp_type" id="supp_type"/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="'.$valid.'"/></td>
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
