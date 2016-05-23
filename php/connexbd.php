<?php
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
