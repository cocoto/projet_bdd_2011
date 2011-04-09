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
		$taille_echantillon_prix=500; //Nombre maximum de prix aléatoires générés
		$prix_max=1000.00; //Prix maximum de l'ensemble des produits (pour la génération aléatoire)
	?>
	<div id="corps">
	<h1>Creation de la base de donnée :</h1>
	<?php
		if (connection_base())
		{
			/*Creation de la Base de donnée à faire côté Serveur (sécurisation)*/
			/*Ajoute les Enseignes*/
			echo "=============================AJOUT DES ENSEIGNES===========================<br/>";
			if ($fichier=fopen('enseignes.csv', 'r'))
			{
				while ($ligne=fgets($fichier)) //Ouverture et parcourt du fichier de donnée CSV
				{
					//echo $ligne;
					$tab=preg_split('#\|#', $ligne); //Explosion d'une des ligne selon le délimiteur |
					$requete='INSERT IGNORE INTO Enseigne(nom_ens,nom_dirg,mdp) VALUES("'.$tab[0].'","'.$tab[1].'","'.sha1($tab[2]).'")';
					if(!execute_requete($requete))
					{
						echo "Problème à j'ajout de l'enseigne".$tab[0].".<br/>";
					}
					else
					{
						echo "Enseigne ".$tab[0]." ajoutée, mot de passe : \"".$tab[2]."\" <br/>";
					}
				}				
			}
			else
			{
				echo "Problème à l\'ouverture du fichier enseignes.csv<br/>";
			}
			echo "=============================FIN AJOUT DES ENSEIGNES===========================<br/>";
			/*Fin ajout des enseignes*/
			/*Ajoute les Magasins*/
			echo "=============================AJOUT DES MAGASINS===========================<br/>";
			if ($fichier=fopen('magasins.csv', 'r'))
			{
				while ($ligne=fgets($fichier)) //Ouverture et parcourt du fichier de donnée CSV
				{
					//echo $ligne;
					$tab=preg_split('#\|#', $ligne); //Explosion d'une des ligne selon le délimiteur |
					$requete='SELECT id_ens FROM Enseigne';
					if ($tab_ens=execute_requete($requete))
					{
						$ens=$tab_ens[rand(0,count($tab_ens)-1)][0];	//Selection d'une enseigne au hasard
						$mot_de_passe="";
						$chaine = "abcdefghijklmnopqrstuvwxyz0123456789";
						$taille=12;
						for ($i=0; $i<$taille; $i++)
						{
							$mot_de_passe.=$chaine[mt_rand(0,35)];
						}
						$requete='INSERT IGNORE INTO Magasin(nom_m,nom_resp,taille,ville,id_ens,mdp)  VALUES("'.$tab[0].'","'.$tab[1].'","'.$tab[2].'","'.$tab[3].'","'.$ens.'","'.sha1($mot_de_passe).'")';
						if(!execute_requete($requete)) //Ajout du 3_uplet produit/prix/magasin, et dispo toujours à 1
						{
							echo "impossible d'ajouter le magasin".$tab[0]."<br/>";
						}
						else{
							echo "Magasin ".$tab[0]." ajouté, mot de passe : \"".$mot_de_passe."\" <br/>";
						}
					}
					else
					{
						# code...
						echo "impossible de récupèrer la liste des magasins<br/>";
					}
				}		
			}
			else
			{
				echo "Problème à l\'ouverture du fichier magasin.csv<br/>";
			}
			echo "=============================FIN AJOUT DES MAGASINS===========================<br/>";
			/*Fin ajout des Magasins*/
			/*Ajoute les produits et catégories rayon*/
			echo "=============================AJOUT DES PRODUITS===========================<br/>";
			if ($fichier=fopen('donnees.csv', 'r'))
			{
				while ($ligne=fgets($fichier)) //Ouverture et parcourt du fichier de donnée CSV
				{
					//echo $ligne;
					$tab=preg_split('#\|#', $ligne); //Explosion d'une des ligne selon le délimiteur |
					$requete='INSERT IGNORE INTO Type(type,rayon) VALUES("'.$tab[2].'","'.$tab[3].'")';//Ajout du type si inexistant
					if (execute_requete($requete))
					{
						$tab[1]=htmlspecialchars($tab[1],ENT_QUOTES);//On échappe les " et '
						$tab[4]=htmlspecialchars($tab[4],ENT_QUOTES);//Dans le titre et la desciption
						$requete='INSERT IGNORE INTO Produit(ref,nom_p,type,description) VALUES("'.$tab[0].'","'.$tab[1].'","'.$tab[2].'","'.$tab[4].'")';
						if (execute_requete($requete))//Ajout du produit dans la table
						{
							echo 'Produit '.$tab[1].' ajouté avec succès !<br/>';
						}
						else
						{
							echo 'Erreur sur le produit '.$tab[1].'lors de l\'ajout !<br/>';
						}
					}
					else
					{
						echo 'Le type '.$tab[2].' n\'à put être ajouté correctement. Vérifiez votre script !<br/>';
					}
				}			
			}
			else
			{
				echo "Problème à l\'ouverture du fichier donnees.csv<br/>";
			}
			echo "=============================FIN AJOUT DES PRODUITS===========================<br/>";
			/*Fin ajout des produits et rayons*/
			echo "=============================GENERATION DES PRIX===========================<br/>";
			/*Ajouts aléatoires des produits en magasin et des prix*/
			echo 'Génération de prix aléatoires.....<br/>';
			$requete='SELECT id_p FROM Produit';
			if ($tab_produit=execute_requete($requete))
			{
				# on récupère les produits et les magasins (id)
				$requete='SELECT id_mag FROM Magasin';
				if ($tab_magasin=execute_requete($requete))
				{
					# code...
					for ($i = 0; $i < $taille_echantillon_prix; $i++)
					{
						# code...
						#print_r($tab_produit);
						$produit=$tab_produit[rand(0,count($tab_produit)-1)]['id_p']; 	//On choisis un id_produit au hasard
						$magasin=$tab_magasin[rand(0,count($tab_magasin)-1)][0];	//idem pour un magasin
						$prix=rand(0,$prix_max*100)/100;				//Génération d'un prix aléatoire (voir en haut)
						$requete='INSERT IGNORE INTO Tarif(id_p,id_mag,prix,dispo) VALUES("'.$produit.'","'.$magasin.'","'.$prix.'","1")';
						if(!execute_requete($requete)) //Ajout du 3_uplet produit/prix/magasin, et dispo toujours à 1
						{
							echo "impossible d'ajouter le prix<br/>";
						}
					}
				}
				else
				{
					# code...
					echo "impossible de récupèrer la liste des magasins<br/>";
				}
			}
			else
			{
				# code...
				echo "impossible de récupèrer la liste des produits<br/>";
			}
			echo "=============================FIN GENERATION DES PRIX===========================<br/>";
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
