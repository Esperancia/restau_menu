<?php 
class Commande{
	private $IdPanier;
	private $IdTable;
	private $Servie;
	private $Payee;
	
	public function getIdPanier(){
	return $this->IdPanier;
	}
	public function setIdPanier($nouveauIdPanier)
	{
	$this->IdPanier = $nouveauIdPanier;
	}

	public function getIdTable(){
	return $this->IdTable;
	}
	public function setIdTable($nouveauIdTable)
	{
	$this->IdTable = $nouveauIdTable;
	}
	
		
	public function getServie(){
	return $this->Servie;
	}
	public function setServie($nServie)
	{
	$this->Servie = $nServie;
	}
	
		
	public function getPayee(){
	return $this->Payee;
	}
	public function setPayee($nPayee)
	{
	$this->Payee = $nPayee;
	}
	
	public function CreerCommande($IdPanier,$IdTable)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
			
			$req='INSERT INTO commande(IdPanier,IdTable) VALUES (:idpanier,:idtable)';	
			// exécuter la req
			$result = $bdd->prepare($req);
			$result->execute(array('idpanier' => $IdPanier,'idtable' => $IdTable));
			//fermer la requete
			$result->closeCursor();
			echo 'Commande lancée !';
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	
	}
	
	public function servirComd($IdTable,$IdTable)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	
	$req='UPDATE commande SET Servie=1 WHERE IdPanier=:idpanier AND IdTable=:idtable';	
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array('idpanier' => $IdPanier, 'IdTable' => $IdTable));
	}
	
	public function payerComd($IdTable,$IdTable)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	
	$req='UPDATE commande SET Payee=1 WHERE IdPanier=:idpanier AND IdTable=:idtable';	
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array('idpanier' => $IdPanier, 'IdTable' => $IdTable));
	}
	
}
?>