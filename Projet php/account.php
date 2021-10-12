<?php
session_start();

require_once 'inc/functions.php';
require_once 'inc/db.php';

$ListeOffres = array();

if( $_SESSION['auth']->u_id == 1){
	$CompteAdmin = 1;
	$req = $dbh->prepare('SELECT * from T_annonce ORDER BY id_annonce DESC ;');
	$req->execute();
	$ListeOffres=$req->fetchAll();
}else{
	$CompteAdmin = 0; 
	$req = $dbh->prepare('SELECT * from T_annonce WHERE u_id = ? ORDER BY id_annonce DESC ;');
	$req->execute([$_SESSION['auth']->u_id]);
	$ListeOffres=$req->fetchAll();
}

?>

<?php require 'inc/header.php'; ?>

<h1> Votre Profil </h1>
<br>

	<button name="create" type="submit" class="btn btn-segundary" ><a href="CreerAnnonce.php"> Créer une annonce </a></button>
	<div class="offres">
       	<?php for ($i = 0; $i < count($ListeOffres); $i++): ?>
        	<div class="sous-offre">
                <div><img src="https://www.xda-developers.com/logo/2020/svg/xda-white-text.svg"   width="100" height="100"></div> 
            	<?php $query_string = 'id_annonce=' . urlencode($ListeOffres[$i]->id_annonce); ?>
            	<div><h5> <a href="annonce.php?<?php echo htmlentities($query_string);?>"> <?php print_r($ListeOffres[$i]->titre); ?></a> </h5>
                <h6><?php print_r($ListeOffres[$i]->description);?> </h6></div>
            </div>
       	 <?php endfor; ?>
	</div>

<br>


    <?php if($CompteAdmin == 1):?>
		<div class="users">
    		<?php 	$req = $dbh->prepare('SELECT * from T_utilisateur ORDER BY u_id DESC ;');
					$req->execute();
					$ListeUser=$req->fetchAll();
    		?>
    			<?php for ($i = 0; $i < count($ListeUser); $i++): ?>
        			<div class="sous-offre">
                    	<?php $query_string = 'u_id=' . urlencode($ListeUser[$i]->u_id); ?>
            			<div><h5> <a href="utilisateur.php?<?php echo htmlentities($query_string);?>"> <?php print_r($ListeUser[$i]->u_pseudo); ?></a> </h5>
                		<h6><?php print_r($ListeUser[$i]->u_mail);?> </h6></div>
            		</div>
       	 <?php endfor; ?>
       <?php endif; ?>
        

<br>

<?php require 'inc/footer.php'; ?>