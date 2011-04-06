<?php
	     echo  "<form action='resultat.php' method='POST'>
			<table id='tableRecherche'>
				<tr>
					<td>Effectuer une recherche : </td>
				</tr>
				<tr>
					<td><input type='text' name='recherche' /></td>
					<td><input type='checkbox' name='description' />Description</td>
				</tr>
				<tr>
					<td><input type='submit' name='valider' value='Ok'/></td>
				</tr>
			</table>
		</form>";
?>
