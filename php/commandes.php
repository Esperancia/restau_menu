<?php 
	session_start();
	include_once('connexbd.php');
	include_once('Commander.class.php');
	include_once('Panier.class.php');
	
	$req='SELECT panier.IdPanier, panier.IdTable, commander.IdElem, elementservi.DescriptionNom, elementservi.MontantUnitaire, 				            SUM(commander.QteCmdee) AS QteCmdee, SUM( elementservi.MontantUnitaire * commander.QteCmdee ) AS Total
			 FROM panier, commander, elementservi
			 WHERE panier.IdPanier = commander.IdPanier	 AND 	commander.IdElem = elementservi.IdElem 
			 AND panier.EtatValidation=1
			 GROUP BY panier.IdPanier, panier.IdTable, commander.IdElem,commander.QteCmdee';
			
	// exécuter la req
	$result = $bdd->query($req);
	// Récupération de toutes les lignes du jeu de résultats	//
	$recup=$result->fetchAll();
	$panier=$recup[0]['IdPanier'];
	$table=$recup[0]['IdTable'];
	echo '<h4>Panier N°: ' . $panier . '&nbsp;Table N°: '. $table . '</h4>' . "\n";
	echo '<h4>Element servi ---  Qté --- PU --- Montant </h4>';
	foreach ($recup as $recupligne)
	{	
		$panier='';
		if( $recupligne['IdPanier'] != $panier ){
		$panier = $recupligne['IdPanier'];
		$table = $recupligne['IdTable'];
		}
		echo '<ul><li>'.$recupligne['DescriptionNom'];
		echo '<input name="id" type="hidden" value="'. $recupligne['IdElem'] . '">';
		echo ' --- '. $recupligne['QteCmdee'];
		echo ' --- '.$recupligne['MontantUnitaire'] .' --- '. $recupligne['Total'] . '</li></ul>';
	}	
	//fermer la requete
	$result->closeCursor();
	
?>