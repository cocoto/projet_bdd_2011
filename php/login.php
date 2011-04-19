<?php
	@session_start();
	echo "<div  id='login'>";
	if(isset($_SESSION['id_mag']) || isset($_SESSION['id_ens']) || isset($_SESSION['admin']))
	{
		if (isset($_SESSION['id_mag']))
		{
			echo 'Magasin : '.$_SESSION['nom_m'].'<br/><input type="button" onclick="self.location.href=\'liste_produits.php\'" value="Changer Tarifs" />';
		}
		if(isset($_SESSION['id_ens']))
		{

			echo 'Enseigne : '.$_SESSION['nom_ens'].'<br/><input type="button" onclick="self.location.href=\'admin_produits.php\'" value="Administration" />';
		}
		if(isset($_SESSION['admin']))
		{
			echo 'Administrateur <br/><input type="button" onclick="self.location.href=\'admin.php\'" value="Administration" />';
		}
		echo '<input type="button" onclick="self.location.href=\'deco.php\'" value="Se déconnecter" />';
	}
	else
	{?>	
		
		<form action="login.php" method="post">
		<table id='tlogin'>	
			<tr>
				<td>login : <input type="text" name="username"/></td>
				<td>password : <input type="password" name="mdp"/></td>
				<td><input type="submit" value="connexion"/></td>
			</tr>
			</table>
		</form>
		
		
	<?php }
	      echo "</div>";
?>

