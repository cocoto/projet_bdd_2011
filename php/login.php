<?php
	@session_start();
	echo "<div  id='login'>";
	if (isset($_SESSION['id_mag']))
	{
		echo 'Magasin : '.$_SESSION['nom_m'].'<br/><a href="deco.php">Se déconecter</a>';
	}
	else if(isset($_SESSION['id_ens']))
	{
		echo 'Enseigne : '.$_SESSION['nom_ens'].'<br/><input type="button" onclick="self.location.href=\'deco.php\'" value="Se déconecter" />';
	}
	else
	{?>	
		<table>	
		<form action="login.php" method=POST>
			<tr>
				<td><input type=text name="username" value="username"/></td>
			</tr>
			<tr>
				<td><input type=password name="mdp" value="password"/></td>
			</tr>
			<tr>
				<td><input type=submit value="accès administration"/></td>
			</tr>
		</form>
		</table>
		
	<?php }
	      echo "</div>";
?>

