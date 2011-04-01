<?php
/*	FICHIER DE FONCTIONS PHP MYSQL DU SITE : A ne pas diffuser	*/
$bdd="";//identifiant de la base de donnée. Variable globale invisible dans les scripts
$host='127.0.0.1';
$login='root';
$mdp='';

/*====Fonction de connection et sélection de base===*/
/*Retourne un booleen de bon fonctionnement, et  un message descriptif de l'erreur*/
/*Attention messages d'erreur visibles pas les utilisateurs, restez clean*/
function connection_base()
{
	global $bdd,$hostname,$login,$mdp;//on appel la variable globale
	$bdd=mysql_connect($hostname,$login,$mdp);//Voir fonction mysql_connect pour changement de serveur
	if (!$bdd)
	{
		echo "Problème de connection à la base de donnée, merci de repasser plus tard";
		return false;
	}
	else
	{
		if (mysql_select_db("Comparateur")) //Voir fonction mysql_select_db pour changement de serveur
		{
			return true;
		}
		else
		{
			echo "Problème de séléction de la base de donnée";
			return false;			
		}
	}
}

/*=======Execution d'une requete=========*/
/*Retourne false en cas de problème lors de la requete*/
/*Retourne TRUE pour un update/insert...*/
/*Retourne un tableau de résultat pour un SELECT...*/
function execute_requete($requete)
{
	$res_requete=mysql_query($requete);
	if (!is_resource($res_requete)) //Retourne le resultat d'un update/insert ou un problème sur un select
	{
		return $res_requete; //True ou False suivant l'execution
	}
	else
	{
		$i=0;
		while ($ligne=mysql_fetch_array($res_requete,MYSQL_BOTH))
		{
			$result[$i]=$ligne;
			$i++;
		} //Création d'un tableau des resultats (utiliser print_r($tab) pour vérifier)
		return $result;
	}
}


function deconnection_base()
{
	global $bdd;
	mysql_close($bdd);
}
