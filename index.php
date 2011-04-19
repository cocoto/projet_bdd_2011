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
		

		<h2>Bienvenue sur Notre comparateur de prix.</h2>
		<?php include('php/nbProduit.php'); ?>
		<p class='texte'>Si vous êtes directeur d'un magasin, vous pouvez accéder à notre section membre via l'onglet "membre" juste au-dessus.</p>
		<p class='texte'>Vous pouvez effectuer une recherche par nom de produit ou par description ou bien les deux à la fois.</p>
		<br/>
		<hr/>
		<br/>
		<?php include("php/formulaireRecherche.php"); ?>
		<br/>
		<hr/>
		
		<table id='list'>
		
				<?php
					/* Selection et affichage de tous les rayons */
					connection_base();
					$req='Select distinct(rayon),type from Type group by rayon order by rayon,type asc';
					$res=execute_requete($req);

					echo "<tr>";
						for($i=0;$i<count($res);$i++){
							echo "<td class='tdlist'><a href=\"resultat.php?rayon=".$res[$i][0]."\">".ucfirst($res[$i][0])."</a></td>";
						}
					echo "</tr>";
					echo "<tr id='trlist'>";
						for($i=0;$i<count($res);$i++){
							//Pour chaque rayon on séléctionne et affiche les types associés
							$req2='Select type From Type Where rayon="'.$res[$i][0].'"';
							$res2=execute_requete($req2);
							echo "<td class='tdlist'>";
							
							for($j=0;$j<count($res2);$j++){
								echo "<a href=\"resultat.php?type=".$res2[$j][0]."\">".ucfirst($res2[$j][0])."</a><br/>";
							}
							
							echo "</td>";			
							
						}	
					echo "</tr>";
					deconnection_base();
				?>
		</table>
		
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
