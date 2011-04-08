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
				if(isset($_POST['username'])&&isset($_POST['mdp']))
				{
					$username=htmlspecialchars($_POST['username']);
					$mdp=sha1($_POST['mdp']);
					$requete='SELECT id_ens,nom_ens FROM Enseigne WHERE nom_ens="'.$username.'" AND mdp="'.$mdp.'"';
					$resultat=execute_requete($requete);
					if(count($resultat)>0)
					{
						$_SESSION['id_ens']=$resultat[0]['id_ens'];
						$_SESSION['nom_ens']=$resultat[0]['nom_ens'];
						echo "Connection Effectuée avec succes !";
					}
					else
					{
						$requete='SELECT id_mag,nom_m FROM Magasin WHERE nom_m="'.$username.'" AND mdp="'.$mdp.'"';
						$resultat=execute_requete($requete);
						if(count($resultat)>0)
						{
							$_SESSION['id_mag']=$resultat[0]['id_mag'];
							$_SESSION['nom_m']=$resultat[0]['nom_m'];
							echo "Connection Effectuée avec succes !";
						}
						else
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
		history.back();
	</script>
	<? include("php/foot.php"); ?>
</body>


</html>
