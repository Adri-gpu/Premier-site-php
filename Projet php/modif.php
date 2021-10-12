<?php
session_start();

require_once 'inc/db.php';
require_once 'inc/functions.php';

if(isset($_POST['delete'])){	
	$req = $dbh->prepare('DELETE FROM T_utilisateur WHERE u_id = ?');
	$req->execute([$_SESSION['auth']->u_id]);
	unset($_SESSION['auth']);
   	$_SESSION['flash']['success'] ="Votre compte a bien été supprimé";
	header('location: index.php');
	exit();
}

if(!empty($_POST)){
    $errors = array();
	if(empty($_POST['username'])){
    	$_POST['username']= $_SESSION['auth']->u_pseudo;
   	}else{
    	if(!preg_match('/^[a-zA-Z0-9_]+$/' , $_POST['username'])){
        	$errors['username'] = "Vous n'avez pas entré de pseudo valide";
    	}else{
       	 	$req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_pseudo = ?');
        	$req->execute([$_POST['username']]);
        	$user = $req->fetch();
        	if($user){
          	 		$errors['username'] = 'Ce pseudo est déjà pris';
        	}
    	}	
    }
	
    if(empty($_POST['name'])){
    	$_POST['name']= $_SESSION['auth']->u_nom;
   	}
    
    if(empty($_POST['surname'])){
    	$_POST['surname']= $_SESSION['auth']->u_prenom;
   	 }

	if(empty($_POST['password'])){
    	$_POST['password'] = $_SESSION['auth']->u_mdp;
   		$_POST['password_control'] = $_SESSION['auth']->u_mdp;
    }else{
    	if($_POST['password'] != $_POST['password_control']){
        	$errors['password'] = 'Les mots de passe ne correspondent pas';
        }
    }
    	
	if(empty($errors)){
        $req = $dbh->prepare("UPDATE T_utilisateur SET u_pseudo = ?, u_nom = ?, u_prenom = ?, u_mdp = ? WHERE u_mail = ?");
       	$req->execute([$_POST['username'],$_POST['name'],$_POST['surname'], $_POST['password'], $_SESSION['auth']->u_mail]);
    	$_SESSION['flash']['success'] = "Votre compte a bien été modifié";
    	$mail = $_SESSION['auth']->u_mail;
   		unset($_SESSION['auth']);
   		$req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_mail = ?');
   		$req->execute([$mail]);
   		$user = $req->fetch();
   		$_SESSION['auth'] = $user;
   		header ('location: account.php');
   		exit();
   	}
}

?>

<?php require 'inc/header.php';?>

<h1> Gérer le compte </h1>

<?php if(!empty($errors)): ?>

<div class="alert alert-danger">

    <p>Vous n'avez pas rempli le formulaire correctement.</p>
    <ul>
    <?php foreach($errors as $error): ?>
        <li><?= $error; ?></li>
    <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>
<br>


<form action="" method="POST">
	<h5>Votre pseudo actuel est: <?php print_r($_SESSION['auth']->u_pseudo)?></h5>
	<div class="form-group">
    	<input type="text" name="username" class="form-control" />
    </div>
   
	<h5>Votre nom actuel est: <?php print_r($_SESSION['auth']->u_nom)?></h5>
	<div class="form-group">
        <input type="text" name="name" class="form-control" />
    </div>
	
	<h5>Votre prénom actuel est: <?php print_r($_SESSION['auth']->u_prenom)?> </h5>
	<div class="form-group">
        <input type="text" name="surname" class="form-control" />
    </div>

	<br>
	<h5>Modifier le mot de passe</h5>
	<div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Changer le mot de passe"/>
	</div>
<br>

	<div class="form-group">
        <input type="password" name="password_control" class="form-control" placeholder="Confirmer le changement" />
    </div>
	<div>
    <br>
		<button type="submit" class="btn btn-primary"> Modifier </button>
    	
    	<button name="delete" type="delete" class="btn btn-danger" style="float:right">Supprimer mon compte</button>
    	
	</div>
	<br>	
</form>

<?php require 'inc/footer.php'; ?>