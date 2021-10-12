<?php

require_once 'inc/functions.php';

if(!empty($_POST)){

    $errors = array();

    require_once 'inc/db.php';

    if(empty($_POST['username'])  ||  !preg_match('/^[a-zA-Z0-9_]+$/' , $_POST['username'])){
        $errors['username'] = "Vous n'avez pas entré de pseudo valide";
    }else{
        $req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_pseudo = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = 'Ce psuedo est déjà pris';
        }
    }
	
	if(empty($_POST['name'])  ||  !preg_match('/^[a-zA-Z]+$/' , $_POST['name'])){
        $errors['name'] = "Vous n'avez pas entré de nom";
    }

	if(empty($_POST['surname'])  ||  !preg_match('/^[a-zA-Z]+$/' , $_POST['surname'])){
        $errors['surname'] = "Vous n'avez pas entré de prénom";
    }

    if(empty($_POST['email'])  ||  !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    }else{
        $req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_mail = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cet email est déjà pris';
        }
    }

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Votre mot de passe n'est pas valide";
    }
	
	
    if(empty($errors)){
        $req = $dbh->prepare("INSERT INTO T_utilisateur SET u_mail = ?,u_pseudo = ?, u_mdp = ?, u_nom = ?, u_prenom = ?");
        $req->execute([$_POST['email'],$_POST['username'],$_POST['password'],$_POST['name'],$_POST['surname']]);
    	session_start();
    	$_SESSION['flash']['success'] = "Votre compte a bien été créé";
    	header ('location: login.php');
    	exit();
    }
    
}
?>

<?php require 'inc/header.php'; ?>

<h1> S'inscrire </h1>

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

<form action="" method="POST">

    <div class="form-group">
        <label for=""> Pseudo </label>
        <input type="text" name="username" class="form-control" />
    </div>
   
	<div class="form-group">
        <label for=""> Nom </label>
        <input type="text" name="name" class="form-control" />
    </div>
	
	<div class="form-group">
        <label for=""> Prénom </label>
        <input type="text" name="surname" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Email </label>
        <input type="email" name="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Mot de Passe </label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Confirmation </label>
        <input type="password" name="password_confirm" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary"> Valider </button>

</form>


<?php require 'inc/footer.php'; ?>