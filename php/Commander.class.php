<?php 
class Commander{
	private $IdPanier;
	private $IdElem;
	private $QteCmdee;
	private $Prix;
	
	public function getIdPanier(){
	return $this->IdPanier;
	}
	public function setIdPanier($nouveauIdPanier)
	{
	$this->IdPanier = $nouveauIdPanier;
	}
	
	public function getIdElem(){
	return $this->IdElem;
	}
	public function setIdElem($nouveauIdElem)
	{
	$this->IdElem = $nouveauIdElem;
	}
	
	public function getQteCmdee(){
	return $this->QteCmdee;
	}
	public function setQteCmdee($nouveauIdElem)
	{
	$this->QteCmdee = $nouveauQteCmdee;
	}
	
	public function ajouterPlat($IdPanier, $IdElem, $QteCmdee)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
			
			//faire la requete qui consiste à récupérer pour chaque prix ses infos:categorie, nom, image, prix
			$req='SELECT MontantUnitaire FROM elementservi WHERE elementservi.IdElem=?';
					
			// exécuter la req
			$result = $bdd->prepare($req);
			$result->execute(array($IdElem));
			// Récupération de toutes les lignes du jeu de résultats
			$recup=$result->fetchAll();
			foreach($recup as $prixu)
				{
					$pu=$prixu[0];
				}
			//fermer la requete
			$result->closeCursor();
			
			$req = $bdd->prepare('INSERT INTO commander(IdPanier, IdElem, QteCmdee, Prix) VALUES(:IdPanier,
			:IdElem, :QteCmdee, :Prix)');
			$req->execute(array(
			'IdPanier' => $IdPanier,
			'IdElem' => $IdElem,
			'QteCmdee' => $QteCmdee,
			'Prix' => $pu * $QteCmdee,
			));
			echo 'Le plat a bien été ajouté !';
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	
	
	}
	
	public function __construct($IdPanier,$IdElem)
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
	// Récupérer en base de données les infos du membre
	// SELECT pseudo, email, signature, actif FROM membres WHERE id = ...
	// Définir les variables avec les résultats de la base
	//faire la requete qui consiste à récupérer pour chaque prix ses infos:categorie, nom, image, prix
	$req='SELECT * FROM commander WHERE IdPanier=? and IdElem=?';
			
	// exécuter la req
	$result = $bdd->prepare($req);
	$result->execute(array($IdPanier,$IdElem));
	// Récupération de toutes les lignes du jeu de résultats
	$recup=$result->fetchAll();
	foreach($recup as $paniercontenantelement)
		{
			$this->IdPanier = $paniercontenantelement['IdPanier'];
			$this->IdElem = $paniercontenantelement['IdElem'];
			$this->QteCmdee = $paniercontenantelement['QteCmdee'];
			$this->Prix = $paniercontenantelement['Prix'];
		}
	//fermer la requete
	$result->closeCursor();
	}

	public function modifChaqLignCmd($IdPanier, $IdElem, $QteCmdee)
	{
		try
		{
			// on essaie de se connecter à la base
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$bdd = new PDO('mysql:host=localhost;dbname=t', 'root', '',$pdo_options);
			//si connexion réussie, informer //echo 'Connexion réussie';
			
			//faire la requete qui consiste à récupérer pour chaque prix ses infos:categorie, nom, image, prix
			$req='SELECT MontantUnitaire FROM elementservi WHERE elementservi.IdElem=?';
					
			// exécuter la req
			$result = $bdd->prepare($req);
			$result->execute(array($IdElem));
			// Récupération de toutes les lignes du jeu de résultats
			$recup=$result->fetchAll();
			foreach($recup as $prixu)
				{
					$pu=$prixu[0];
				}
			//fermer la requete
			$result->closeCursor();
			
			$req = $bdd->prepare('UPDATE commander SET QteCmdee=:QteCmdee, Prix=:Prix
									WHERE commander.IdPanier=:IdPanier AND commander.IdElem=:IdElem');
			$req->execute(array(
			'QteCmdee' => $QteCmdee,
			'IdPanier' => $IdPanier,
			'IdElem' => $IdElem,
			'Prix' => $pu * $QteCmdee,
			));
			echo 'Quantité modifiée !';
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}	
	
	}
	
	public function purger()
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
	$req='DELETE FROM commander WHERE QteCmdee=0';	
	$result = $bdd->exec($req);
	}
	
}
?>