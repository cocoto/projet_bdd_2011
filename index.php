<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>Comparateur de prix</title>
	<link href="CSS/style.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
	<?php include ("php/login.php");?>
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
	</div>
	
	<? include("php/foot.php"); ?>
</body>


</html>
