<?php
	@session_start();
	echo "<div  id='login'>";
	if (isset($_SESSION['id_mag']))
	{
		echo 'Magasin : '.$_SESSION['nom_m'].'<br/><input type="button" onclick="self.location.href=\'deco.php\'" value="Se déconnecter" /><input type="button" onclick="self.location.href=\'liste_produits.php\'" value="Changer Tarifs" />';
	}
	else if(isset($_SESSION['id_ens']))
	{

		echo 'Enseigne : '.$_SESSION['nom_ens'].'<br/><input type="button" onclick="self.location.href=\'deco.php\'" value="Se déconnecter" /><input type="button" onclick="self.location.href=\'admin_produits.php\'" value="Administration" />';
	}
	else if(isset($_SESSION['admin']))
	{
		echo 'Administrateur : <br/><input type="button" onclick="self.location.href=\'deco.php\'" value="Se déconnecter" /><input type="button" onclick="self.location.href=\'admin.php\'" value="Administration" />';

	}
	else
	{?>	
		<table id='tlogin'>	
		<form action="login.php" method=POST>
			<tr>
				<td>login : <input type=text name="username"/></td>
				<td>password : <input type=password name="mdp"/></td>
				<td><input type=submit value="connection"/></td>
			</tr>
		</form>
		</table>
		
	<?php }
	      echo "</div>";
?>

