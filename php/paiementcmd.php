<?php 
	session_start();
	include_once('connexbd.php');
	include_once('Commander.class.php');
	include_once('Panier.class.php');
	
	$req='SELECT commande.IdPanier, commande.IdTable, SUM( elementservi.MontantUnitaire * commander.QteCmdee ) AS Total
		 	 FROM commande, panier, commander, elementservi
			WHERE panier.IdPanier = commander.IdPanier
			AND commander.IdElem = elementservi.IdElem
			AND commande.Servie = 1 GROUP BY commande.IdPanier';
			
	// exécuter la req
	$result = $bdd->query($req);
	// Récupération de toutes les lignes du jeu de résultats	//
	$recup=$result->fetchAll();
	//while ($recupligne= $result->fetch())
	echo '<tr><td width="200em">Panier N°:</td><td width="200em">Table N°:</td><td width="200em">Montant dû</td></tr>';
	foreach($recup as $recupligne)
	{
	echo '<table><form action="panier.php" method="post">';
	echo '<tr><td width="200em">'.$recupligne['IdPanier'].'</td>';
	echo '<td width="200em">'. $recupligne['IdTable'] . '</td>';
	echo '<td width="200em">'. $recupligne['Total'] . '</td>';
	echo '<input name="IdPanier" type="hidden" value="'.$recupligne['IdPanier'].'" />';
	echo '<input name="IdTable" type="hidden" value="'.$recupligne['IdTable'].'" />';
	echo '<td><input name="btnPayer" type="submit" value="Payer" /></td></tr></form></table>';
	}	
	//fermer la requete
	$result->closeCursor();
		
//traitem sur clic valider panier
	if (isset($_POST['IdPanier']) && isset($_POST['IdTable'])){
		$commande = new Commande();
		$panier->payerComd($_POST['IdPanier'],$_SESSION['IdTable']);
		header('Location: paiementcmd.php');
	}
	
?>
