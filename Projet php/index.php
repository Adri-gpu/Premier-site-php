<?php
require_once 'inc/functions.php';
require_once 'inc/db.php';

$ListeOffres = array();

$req=$dbh->query('SELECT * from T_annonce WHERE etat_annonce="publier" ORDER BY id_annonce DESC limit 6;');
$ListeOffres=$req->fetchAll();

?>

<link href="css/app.css" rel="stylesheet">

<?php require 'inc/header.php'; ?>

<h1> Bienvenue </h1>

<div class="alignement">
    <h1 class="t_souligne"> Liste des 6 dernières offres postées</h1>
		<div class="offres">
         <?php for ($i = 0; $i < count($ListeOffres); $i++): ?>
        	<div class="sous-offre">
            <?php if(($_SESSION['auth']->u_id) == ($ListeOffres[$i]->u_id)): ?> 
                <div><img src="https://www.xda-developers.com/logo/2020/svg/xda-white-text.svg"   width="100" height="100"></div> 
            	<?php $query_string = 'id_annonce=' . urlencode($ListeOffres[$i]->id_annonce); ?>
            	<div><h5> <a href="annonce.php?<?php echo htmlentities($query_string);?>" style="color:#FF0000"> <?php print_r($ListeOffres[$i]->titre); ?></a> </h5>
                <h6><?php print_r($ListeOffres[$i]->description);?> </h6></div>
            <?php endif; ?>
            <?php if(($_SESSION['auth']->u_id) != ($ListeOffres[$i]->u_id)): ?> 
                <div><img src="https://www.xda-developers.com/logo/2020/svg/xda-white-text.svg"   width="100" height="100"></div> 
            	<?php $query_string = 'id_annonce=' . urlencode($ListeOffres[$i]->id_annonce); ?>
            	<div><h5> <a href="annonce.php?<?php echo htmlentities($query_string);?>"> <?php print_r($ListeOffres[$i]->titre); ?></a> </h5>
                <h6><?php print_r($ListeOffres[$i]->description);?> </h6></div>
            <?php endif; ?>
		</div>
		<?php endfor;?>
</div>


<?php require 'inc/footer.php'; ?>