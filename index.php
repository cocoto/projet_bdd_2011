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
		

		<h2>Bienvenue sur Notre comparateur de prix.</h2>
		<p>Si vous êtes directeur d'un magasin, vous pouvez accéder à notre section membre via l'onglet "membre" juste au-dessus.</p>
		<p>Vous pouvez effectuer une recherche par Rayon/Catégorie/Déscription...</p>
		<br/>
		<hr/>
		<br/>
		<?php include("php/formulaireRecherche.php"); ?>
		<br/>
		<hr/>
		<table id='list'>
		
				<?php
					connection_base();
					$req='Select distinct(rayon),type from Type group by rayon order by rayon,type asc';
					$res=execute_requete($req);

					echo "<tr>";
						for($i=0;$i<count($res);$i++){
							echo "<td id='tdlist'><a href=\"resultat.php?rayon=".$res[$i][0]."\">".$res[$i][0]."</a><td/>";
						}
					echo "</tr>";
					echo "<tr id='trlist'>";
						for($i=0;$i<count($res);$i++){
							$req2='Select type From Type Where rayon="'.$res[$i][0].'"';
							$res2=execute_requete($req2);
							echo "<td id='tdlist'>";
							echo "<ul>";
							for($j=0;$j<count($res2);$j++){
								echo "<li>".$res2[$j][0]."</li>";
							}
							echo "</ul>";
							echo "<td>";			
							
						}	
					echo "</tr>";
				?>
				<td>
					<ul>
						
					</ul>
				</td>
			</tr>
		</table>
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
