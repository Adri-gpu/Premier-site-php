<?php
session_start();
require_once 'inc/functions.php';
require_once 'inc/db.php';

$id = $_GET['u_id'];

$req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_id = ?');
$req->execute([$id]);
$user = $req->fetch();

$Offre = array();

$req = $dbh->prepare('SELECT * FROM T_annonce WHERE u_id = ?');
$req->execute([$user->u_id]);
$Offre = $req->fetchAll();

if(($_SESSION['auth']->u_id) == 1){
	$CompteAuteur = true;
}else{
	$CompteAuteur = false;
}

if(isset($_POST['delete']))       
	{	
		$req = $dbh->prepare('DELETE FROM T_utilisateur WHERE u_id = ?');
		$req->execute([$user->u_id]);
    	$_SESSION['flash']['success'] = "L'utilisateur a bien été supprimée";
		header('location: index.php');
		exit();
	}

if(isset($_POST['bloque'])){	
	$etat = "Bloque";
	$req = $dbh->prepare('UPDATE T_annonce SET etat_annonce = ?');
	$req->execute([$etat]);
    $_SESSION['flash']['success'] = "Les annonces ont bien été bloquées";
	header('location: index.php');
	exit();
}

if(isset($_POST['Envoyer'])){
	$req = $dbh->prepare('INSERT INTO T_message SET id_annonce = ?, u_mail = ?, m_texte_message = ?');
	$req->execute([$id, $_SESSION['auth']->u_mail,$_POST['message']]);
    $_SESSION['flash']['success'] = "Votre message a bien été envoyée";
}
?>


<?php require 'inc/header.php'; ?>

    <div class="form-group">
        <h2 for=""> <?php print_r($user->u_pseudo);?> </h2>
    </div>
   
	<div class="form-group">
        <h5 for=""> <?php print_r($user->u_mail);?> </h5>
    </div>
	<form action="" method="POST">
	         <textarea placeholder="Votre message" name="message"></textarea>
	         <br /><br />
   		 	<button name="Envoyer" type="submit" class="btn btn-primary"> Envoyer un message </button>
		<?php if($CompteAuteur == true && $user->u_id != 1): ?>		
    		<?php $query_string = 'u_id=' . urlencode($user->u_id); ?>
    			<button name="modif" type="submit" class="btn btn-segundary"><a href="modif.php?<?php echo htmlentities($query_string);?>">Modifer</a></button>
    		    <button name="delete" type="submit" class="btn btn-danger">Supprimer</button>
    			<button name="bloque" type="submit" class="btn btn-danger">Bloquer les annonces</button>
		<?php endif;?>
	</form>
	 <div class="offres">
        <?php for ($i = 0; $i < count($Offre); $i++): ?>
        	<div class="sous-offre">
                <div><img src="https://www.xda-developers.com/logo/2020/svg/xda-white-text.svg"   width="100" height="100"></div> 
            	<?php $query_string = 'id_annonce=' . urlencode($Offre[$i]->id_annonce); ?>
            	<div><h5> <a href="annonce.php?<?php echo htmlentities($query_string);?>"> <?php print_r($Offre[$i]->titre); ?></a> </h5>
                <h6><?php print_r($Offre[$i]->description);?> </h6></div>
            </div>
        <?php endfor; ?>
	</div>

<?php require 'inc/footer.php'; ?>