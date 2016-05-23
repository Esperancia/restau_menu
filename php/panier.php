<?php 
	session_start();
	include_once('connexbd.php');
	include_once('Commander.class.php');
	include_once('Commande.class.php');
	include_once('Panier.class.php');
	
	$req='SELECT panier.IdPanier, panier.IdTable, commander.IdElem, elementservi.DescriptionNom, elementservi.MontantUnitaire, 				             commander.QteCmdee 	 FROM panier, commander, elementservi
			 WHERE panier.IdPanier = commander.IdPanier
			 AND 	commander.IdElem = elementservi.IdElem AND commander.QteCmdee>0
			 GROUP BY panier.IdPanier, panier.IdTable, commander.IdElem, elementservi.MontantUnitaire, commander.QteCmdee 
			 HAVING panier.IdPanier=:idpanier';
			
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array('idpanier' => $_SESSION['IdPanier']));
	// Récupération de toutes les lignes du jeu de résultats	//
	$recup=$result->fetchAll();
	$panier = $recup[0]['IdPanier'];
	$table = $recup[0]['IdTable'];
	echo '<table><th><h4>Panier N°' . $panier . '</h4></th>' . "\n";
	echo '<th><h4>Table N°' . $table . '</h4></th>' . "\n";
	//while ($recupligne= $result->fetch())
	echo '<tr><td width="200em">Element choisi</td><td>Quantité</td><td>Prix unitaire</td>
    		<td>Montant</td> </tr>';

	foreach($recup as $recupligne)
	{
	echo '<form action="panier.php" method="post"><td><input name="id" type="hidden" size="5" value="'. $recupligne['IdElem'] . '"></td>';
	echo '<tr><td>'.utf8_encode($recupligne['DescriptionNom']).'</td>';
	echo '<td><input name="qte" type="text" size="5" value="'. $recupligne['QteCmdee'] . '"></td>';
	echo '<td><input name="pu" type="text" size="10" value="'. $recupligne['MontantUnitaire'] . '"></td>';
	echo '<td><input name="pu" type="text" size="15" value="'. $recupligne['MontantUnitaire'] * $recupligne['QteCmdee']. '"></td>';
	echo '<td></td><td></td>';
	echo '<td><input name="btnModif" type="submit" value="Modifier" /></td></tr></form>';
	}	
	echo '</table>';

	//fermer la requete
	$result->closeCursor();
	
	//faire la requete qui consiste à récupérer total commande
	$req1='SELECT SUM( elementservi.MontantUnitaire * commander.QteCmdee )
			FROM panier, commander, elementservi
			WHERE panier.IdPanier = commander.IdPanier
			AND commander.IdElem = elementservi.IdElem
			AND panier.IdPanier =:idpanier';
			
	// exécuter la req
	$result1 = $bdd->prepare($req1);
	$result1->execute(array('idpanier' => $_SESSION['IdPanier']));
	// Récupération de toutes les lignes du jeu de résultats
	$recup1=$result1->fetchAll();
	foreach($recup1 as $total)
	{
		echo '<table><tr><td width="315em"></td><td><strong>Total</strong></td><td><strong>'.$total[0].'</strong></td></tr></table>';
	}

	//fermer la requete
	$result1->closeCursor();
	
	echo '<form action="panier.php" method="post"><input name="validpanier" type="hidden" value="1" />
			<input name="btnvalidpanier" type="submit" value="Valider panier" /></form>';
	echo '<a href="cartemenu.php">Retour vers la carte menu</a>';
	
	//traitement sur clic sur modifier lign cmd	
	if (isset($_POST['id'])&&(isset($_POST['qte']))){
		echo $_POST['id'];
		$Commander = new Commander($_SESSION['IdPanier'], $_POST['id']);
		$Commander->modifChaqLignCmd($_SESSION['IdPanier'],$_POST['id'],$_POST['qte']);
		$Commander->purger();
		header('Location: panier.php');
	}
		
//traitem sur clic valider panier
	if (isset($_POST['validpanier'])){
		$panier = new Panier();
		$panier->validerPanier($_SESSION['IdPanier']);
		$commande = new Commande();
		$commande->CreerCommande($_SESSION['IdPanier'],$_SESSION['table']);
		session_destroy();
		header('Location: choixtable.php');
	}
	
?>
