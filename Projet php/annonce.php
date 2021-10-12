<?php
session_start();
require_once 'inc/functions.php';
require_once 'inc/db.php';

$numero = $_GET['id_annonce'];

$req = $dbh->prepare('SELECT * FROM T_annonce WHERE id_annonce = ?');
$req->execute([$numero]);
$Offre = $req->fetch();

$req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_id = ?');
$req->execute([$Offre->u_id]);
$user = $req->fetch();

if(($_SESSION['auth']->u_id) == ($Offre->u_id) || ($_SESSION['auth']->u_id) == 1){
	$CompteAuteur = true;
}else{
	$CompteAuteur = false;
}

if(isset($_POST['delete'])){	
	$req = $dbh->prepare('DELETE FROM T_annonce WHERE id_annonce = ?');
	$req->execute([$numero]);
    $_SESSION['flash']['success'] = "L'annonce a bien été supprimée";
	header('location: index.php');
	exit();
}

if(isset($_POST['bloque'])){	
	$etat = "Bloque";
	$req = $dbh->prepare('UPDATE T_annonce SET etat_annonce = ? WHERE id_annonce = ?');
	$req->execute([$etat,$numero]);
    $_SESSION['flash']['success'] = "L'annonce a bien été bloquée";
	header('location: index.php');
	exit();
}

if(isset($_POST['Envoyer'])){
	$req = $dbh->prepare('INSERT INTO T_message SET id_annonce = ?, u_mail = ?, m_texte_message = ?');
	$req->execute([$numero, $_SESSION['auth']->u_mail,$_POST['message']]);
    $_SESSION['flash']['success'] = "Votre message a bien été envoyée";
}
?>

<?php require 'inc/header.php'; ?>

    <div class="form-group">
        <h2 for=""> <?php print_r($Offre->titre);?> </h2>
    </div>
        <div>
        	<img style="background:url(http://dummyimage.com/500x500);" width="500" height="500"/>
    	</div>
    	<br>
    	<div>
			<h4>Coût du loyer : <?php print_r($Offre->cout_loyer);?></h4>
			<h4>Coût des charges : <?php print_r($Offre->cout_charges);?></h4>
    		<h4>Superficie : <?php print_r($Offre->superficie);?>m²</h4>
    		<h4>Type : T<?php print_r($Offre->T_type);?></h4>
    		<h4>Adresse : <?php print_r($Offre->adresse);?></h4>	
    		<h4>Ville : <?php print_r($Offre->ville);?>,<?php print_r($Offre->cp);?></h4>
        </div>
	<br>
	<div class="form-group">
        <h5 for="">Description: <?php print_r($Offre->description);?> </h5>
    </div>
	<div class="form-group">
    <?php $query_string = 'u_id=' . urlencode($user->u_id); ?>
    <h5 for=""><p>Publié par: <a href="utilisateur.php?<?php echo htmlentities($query_string);?>"><?php print_r($user->u_pseudo);?> </a></p></h5>
    </div>
	<br>
	<form action="" method="POST">
		<?php if($CompteAuteur == false): ?>
	         <textarea placeholder="Votre message" name="message"></textarea>
	         <br /><br />
   		 	<button name="Envoyer" type="submit" class="btn btn-primary"> Envoyer un message </button>
		<?php endif;?>
		<?php if($CompteAuteur == true):?>
    		<?php $query_string = 'id_annonce=' . urlencode($numero); ?>
    		<button name="modifier" type="submit" class="btn btn-segundary"><a href="ModifierAnnonce.php?<?php echo htmlentities($query_string);?>"> Modifier l'annonce </a></button>
    		<button name="delete" type="submit" class="btn btn-danger">Supprimer</button>
		<?php endif;?>
        <?php if(($_SESSION['auth']->u_id) == 1): ?>
    		<button name="bloque" type="submit" class="btn btn-danger">Bloquer l'annonce</button>
    	<?php endif;?>
	</form>
<br>

<?php require 'inc/footer.php'; ?>