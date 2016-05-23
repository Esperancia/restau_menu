<?php 
class Panier{
	private $IdPanier;
	private $EtatValidation;
	private $IdTable;
	
	public function getIdPanier(){
	return $this->IdPanier;
	}
	public function setIdPanier($nouveauIdPanier)
	{
	$this->IdPanier = $nouveauIdPanier;
	}
	
	public function getEtatValidation(){
	return $this->EtatValidation;
	}
	public function setEtatValidation($nouveauEtatValidation)
	{
	$this->EtatValidation = $nouveauEtatValidation;
	}
	
	public function getIdTable(){
	return $this->IdTable;
	}
	public function setIdTable($nouveauIdTable)
	{
	$this->IdTable = $nouveauIdTable;
	}
	
	public function CreerPanier($IdTable)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
			
			$req='INSERT INTO panier(IdTable) VALUES (:idtable)';	
			// exécuter la req
			$result = $bdd->prepare($req);
			$result->execute(array('idtable' => $IdTable));
			//fermer la requete
			$result->closeCursor();
			echo 'Le panier est créé !';
			
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
			
			$res=$bdd->query('SELECT MAX(IdPanier) FROM panier');
			// Récupération de toutes les lignes du jeu de résultats
			$rec=$res->fetchAll();
			//fermer la requete
			$res->closeCursor();
			foreach($rec as $id)
				{
					$idpanier=$id[0];
				}
			return $idpanier;
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	

	
	}
	
	public function panierencours()
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
	$req='SELECT * FROM panier ORDER BY IdPanier desc LIMIT 0,1';	
	// exécuter la req
	$result = $bdd->query($req);
	// Récupération de toutes les lignes du jeu de résultats
	$recup=$result->fetchAll();
	//fermer la requete
	$result->closeCursor();
	$this->IdPanier = $recup['IdPanier'];
	$this->IdTable = $recup['IdTable'];
	}
	
	public function ModifierTablePanier($IdTable)
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
	$req='UPDATE panier, commander SET IdTable=:idtable';	
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array('IdTable' => $IdTable));
	}
	
public function validerPanier($IdPanier)
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
	$req='UPDATE panier SET EtatValidation=1 WHERE panier.IdPanier=:IdPan';	
	$result = $bdd->prepare($req);
	$result->execute(array('IdPan' => $IdPanier));
	}
	
	public function selectpanier($IdPanier)
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
	
	$req='SELECT * FROM panier WHERE IdPanier=?';
			
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array($IdPanier));
	// Récupération de toutes les lignes du jeu de résultats
	$recup=$result->fetchAll();
	foreach($recup as $lepanier)
		{
			$this->IdPanier = $lepanier['IdPanier'];
			$this->EtatValidation = $lepanier['EtatValidation'];
			$this->IdTable = $lepanier['IdTable'];
		}
	//fermer la requete
	$result->closeCursor();
	}


}
?>