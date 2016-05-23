<?php 
	session_start();
	include_once('connexbd.php');
	
	include_once('Commander.class.php');
	include_once('Panier.class.php');
	
	if (isset($_POST['tableselect'])){
		$_SESSION['table']=$_POST['tableselect'];
		$Panier = new Panier();
		$_SESSION['IdPanier']=$Panier->CreerPanier($_SESSION['table']);
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; user-scalable=0;" />
		<link rel="stylesheet" href="../styles/style.css" type="text/css" />
        <script type="text/javascript" src="../scripts/traitement.js"></script>
        <script type="text/javascript" >
			function signaler()
			{
				alert('Ajouté à la commande!');
			}
		</script>
		<title>Menus proposés</title>
	</head>

<body class="cartemenu">
  <div id="menus">
    <div class="liste">
	<?php 
	//faire la requete qui consiste à récupérer pour chaque prix ses infos:categorie, nom, image, prix
	$req='SELECT * FROM categorie, elementservi WHERE elementservi.IdCategorie = categorie.IdCategorie
			GROUP BY categorie.IdCategorie, categorie.LibCategorie	ORDER BY LibCategorie, DescriptionNom ASC';
			
	// exécuter la req
	$result = $bdd->query($req);

	$rubrique = '';
	//while( $ligne = mysql_fetch_assoc($result) )
	while ($ligne= $result->fetch())
	{
	if( $ligne['LibCategorie'] != $rubrique )
	$rubrique = $ligne['LibCategorie'];
	echo '<h4>' . utf8_encode($rubrique) . '</h4>' . "\n";
	echo '<ul><form action="cartemenu.php" method="post"><li>'.utf8_encode($ligne['DescriptionNom']);
	echo '<input name="id" type="hidden" value="'. $ligne['IdElem'] . '">';
	echo '<input name="ajouter" type="submit" value="+" onClick="signaler();"></li></form>';
	echo '</ul>';
	}	
	// Récupération de toutes les lignes du jeu de résultats	//$recup=$result->fetchAll();
	//fermer la requete
	$result->closeCursor();
	?>
    </div>
  </div>
    
 <?php 
 	if (isset($_POST['id'])){
		include_once('Commander.class.php');
		echo $_POST['id'].'<br>'.$_SESSION['IdPanier'].'<br>';
		$Commander = new Commander($_SESSION['IdPanier'], $_POST['id']);
		$Commander->ajouterPlat($_SESSION['IdPanier'],$_POST['id'],1);
	}
 ?>

<form action="panier.php" method="post">
	<input name="btnvaliderCh" type="submit" value="Valider choix">
</form>

</body>
</html>