<?php
	session_start(); //Démarre puis détruit la session de l'utilisateur
	session_destroy();
?> 
<script language="JavaScript">
	window.location.replace("index.php"); //Redirige vers index.php de manière instantanée
</script>
