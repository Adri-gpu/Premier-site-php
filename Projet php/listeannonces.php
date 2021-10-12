<?php
require_once 'inc/functions.php';
require_once 'inc/db.php';

session_start();

$ListeOffres = array();
$search = array();

$req=$dbh->query('SELECT * from T_annonce WHERE etat_annonce = "publier" ORDER BY id_annonce DESC ;');
$ListeOffres=$req->fetchAll();

if(!empty($_POST)){

    if(empty($_POST['ville'])  ||  !preg_match('/^[a-zA-Z0-9_ ]+$/' , $_POST['ville'])){
    }else{
        $req = $dbh->prepare('SELECT * FROM T_annonce WHERE ville = ? AND etat_annonce = "publier"');
        $req->execute([$_POST['ville']]);
        $search = $req->fetchAll();
        if($search){
				$ListeOffres = $search;
        		$_SESSION['flash']['success']="Résultat correspondant à votre recherche";
        }
    }

	if(empty($_POST['CoutMin'])  ||  !preg_match('/^[0-9]+$/' , $_POST['CoutMin'])){
    }else{
        $req = $dbh->prepare('SELECT * FROM T_annonce WHERE cout_loyer > ? AND etat_annonce = "publier"');
        $req->execute([$_POST['CoutMin']]);
        $search = $req->fetchAll();
        if($search){
				$ListeOffres = $search;
        		$_SESSION['flash']['success']="Résultat correspondant à votre recherche";
		}
    }

	if(empty($_POST['CoutMax'])  ||  !preg_match('/^[0-9]+$/' , $_POST['CoutMax'])){
    }else{
        $req = $dbh->prepare('SELECT * FROM T_annonce WHERE cout_loyer < ? AND etat_annonce = "publier"');
        $req->execute([$_POST['CoutMax']]);
        $search = $req->fetchAll();
        if($search){
			$ListeOffres = $search;
        	$_SESSION['flash']['success']="Résultat correspondant à votre recherche";
        }
   	}
	
	if(!empty($_POST['CoutMax']) && !empty($_POST['CoutMin'])){
    	$req = $dbh->prepare('SELECT * FROM T_annonce WHERE cout_loyer BETWEEN ? AND ? AND etat_annonce = "publier"');
        $req->execute([$_POST['CoutMin'],$_POST['CoutMax']]);
        $search = $req->fetchAll();
    	if($search){
			$ListeOffres = $search;
        	$_SESSION['flash']['success']="Résultat correspondant à votre recherche";
        }
    }
}
?>

<link href="css/app.css" rel="stylesheet">

<?php require 'inc/header.php'; ?>

<div class="alignement">
    <h1> Liste d'annonces</h1>
	<h2> Rechercher</h2>
	<br>
	<form action="" method="POST">
    <div class="">
   		<div class="form-group c">
        	<label for=""> Ville </label>
        	<input type="text" name="ville" class="form-control" />
    	</div>
    
    	<div class="form-group c">
        	<label for=""> Cout Loyer min </label>
        	<input type="number" name="CoutMin" class="form-control" />
    	</div>
    
    	<div class="form-group c">
        	<label for=""> Cout Loyer max </label>
        	<input type="number" name="CoutMax" class="form-control" />
    	</div>
    </div>
    <br>
    	<button type="submit" class="btn btn-primary"> Rechercher </button>
	</form>
	<br>
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
        <?php endfor; ?>
		</div>	
</div>



<?php require 'inc/footer.php'; ?>