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
			/*
			 * Page de connection d'un utilisateur
			 * Le fomulaire est le même, on vérifie que les identifiants sont présents dans une base
			 * Mot de passe de l'administrateur est défini ici en brute, et uniquement ici
			 * En cas de doublons d'identifiants et mot de passe magasin et enseigne (rare), les droits des deux sont attribués
			 */
			if(connection_base())
			{
				if(isset($_POST['username'])&&isset($_POST['mdp']))
				{
					//Traitement du cas administrateur
					if($_POST['username']=="admin" && $_POST['mdp']=="admin")
					{
						$_SESSION['admin']="Administrateur du site";
					}
					else
					{
						$username=htmlspecialchars($_POST['username']);
						$mdp=sha1($_POST['mdp']);
						
						//Traitement du cas Enseigne
						$requete='SELECT id_ens,nom_ens FROM Enseigne WHERE nom_ens="'.$username.'" AND mdp="'.$mdp.'"';
						$resultat_ens=execute_requete($requete);
						if(count($resultat_ens)>0)
						{
							$_SESSION['id_ens']=$resultat_ens[0]['id_ens'];
							$_SESSION['nom_ens']=$resultat_ens[0]['nom_ens'];
							echo "Connection Effectuée avec succes !";
						}
						//Traitement du cas magasin
						$requete='SELECT id_mag,nom_m FROM Magasin WHERE nom_m="'.$username.'" AND mdp="'.$mdp.'"';
						$resultat_mag=execute_requete($requete);
						if(count($resultat_mag)>0)
						{
							$_SESSION['id_mag']=$resultat_mag[0]['id_mag'];
							$_SESSION['nom_m']=$resultat_mag[0]['nom_m'];
							echo "Connection Effectuée avec succes !";
						}
						
						//Si la connection echoue sur les trois types d'utilisateurs
						else if (count($resultat_ens)<=0)
						{
							echo "Vous avez rentré un mauvais couple identifiant/mot de passe";
						}
					}
					
				}
				else
				{
					echo "Vous n'avez pas rentré tous les champs demandés";
				}
			}
			else
			{
				echo "Problème de connection à la base de donnée, merci de revenir plus tard ou de contacter un administrateur";
			}
			deconnection_base();	
			?>
	Redirection dans 5 secondes;
	<!-- <script language='JavaScript'>history.back();</script>-->
	</div>
	<script language="JavaScript">
		history.back(); //Retour direct à la page précédante
	</script>
	<? include("php/foot.php"); ?>
</body>


</html>
