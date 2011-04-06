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
					<td><input type='checkbox' name='description' id='desc' /><label for='desc'>Description</label></td>
					<td><input type='checkbox' name='nom' id='nom' /><label for='nom'>Nom</label></td>
				</tr>
				<tr>
					<td><input type='submit' name='valider' value='Ok'/></td>
				</tr>
			</table>
		</form>";
?>
