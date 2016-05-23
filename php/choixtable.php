<?php 
	session_start();
	include_once('connexbd.php');
	
	//faire la requete 
	$req='SELECT * FROM tablerestau';
			
	// exécuter la req
	$result = $bdd->query($req);
	// Récupération de toutes les lignes du jeu de résultats
	$recup=$result->fetchAll();
	//fermer la requete
	$result->closeCursor();
?>

<!DOCTYPE HTML>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; user-scalable=0;" />
		<link rel="stylesheet" href="../styles/style.css" type="text/css" />
        <script type="text/javascript" src="../scripts/traitement.js"></script>
		<title>Choix de votre table</title>
	</head>

<body class="cartemenu">
<div id="ct_total">
  <div id="ct_indication">Choisissez votre table pour continuer ...</div>
  <div id="lestables">
  	<form action="cartemenu.php" method="post">
    	<select name="tableselect" id="listetable">
        	<option value="0">--Choisissez le numéro de votre table--</option>
            <?php 
				foreach($recup as $numtable)
				{
					echo '<option value="';
					print_r ($numtable[0]); 
					echo '">' ;
					print_r ($numtable[0]);
					echo '</option>';
				}
			?>
        </select>
        <input name="btnContinuer" type="submit" value="Continuer">
    </form>
  </div>
  </div>
</body>
</html>