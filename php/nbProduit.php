<?php

	connection_base();

	$req='Select count(id_p) From Produit';
	$res=execute_requete($req);

	echo "<div id='nbProduit'>";
	$nb=$res[0][0]-1;
	echo "Venez comparer plus de ".$nb." produits !!!!!!!!!!!!!!!!!!!!";
	echo "</div>";
	
	deconnection_base();
?>
