<?php
	@session_start();
	if (isset($_SESSION['id_mag']))
	{
		echo 'Magasin :'.$_SESSION['nom_m'].'<br/><a href="deco.php">Se déconecter</a>';
	}
	else
	{?>
		<form action="login.php" method=POST>
			<input type=text name="username"/>
			<input type=password name="mdp"/>
			<input type=submit value="accès administration"/>
		</form>
	<?php }
?>

