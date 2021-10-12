<?php
unset($_SESSION['auth']);

if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
	
	require_once 'inc/functions.php';
    require_once 'inc/db.php';
	
	$errors = array();

    $req = $dbh->prepare('SELECT * FROM T_utilisateur WHERE u_mail = ?');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($_POST['password'] == $user->u_mdp){
    	session_start();
    	$_SESSION['auth'] = $user;
    	$_SESSION['flash']['success'] = "Connexion réussi";
    	header ('location: account.php');
   		exit();
    }
	else{
    	$errors[] = "Echec de connexion";
    }
}
?>

<?php require 'inc/header.php'; ?>

<h1> Se connecter </h1>

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
        <label for=""> Email </label>
        <input type="email" name="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Mot de Passe</label>
        <input type="password" name="password" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary"> Se connecter </button>

</form>


<?php require 'inc/footer.php'; ?>