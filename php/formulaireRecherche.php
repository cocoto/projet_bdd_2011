<?php
	     echo  "<form action='resultat.php' method='POST'>
			<table id='tableRecherche'>
				<tr>
					<td>Effectuer une recherche : </td>
				</tr>
				<tr>
					<td><input type='text' name='recherche' /></td>
				</tr>
				<tr>
					<td><input type='checkbox' name='description' id='desc' checked /><label for='desc'>Description</label><input type='checkbox' name='nom' id='nom' /><label for='nom'>Nom</label></td>
				</tr>
				<tr>
					<td><input type='checkbox' name='reference' id='ref'/><label for='ref'>Référence</label></td>
				</tr>
				<tr>
					<td><input type='submit' name='valider' value='Ok'/></td>
				</tr>
			</table>
		</form>";
?>
