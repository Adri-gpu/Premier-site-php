<?php  
	if(session_status()== PHP_SESSION_NONE){
   		session_start();
    }

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Morgan Crouzet et Adrien Buffat">
    <title>Immobil'Arles</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<main>
    <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
     	<a href="index.php" class="navbar-brand d-flex align-items-center">
       		<strong>Accueil</strong>
    	</a>
    	<a href="listeannonces.php" class="navbar-brand d-flex align-items-center">Annonces</a>
  		<?php if(isset($_SESSION['auth'])): ?>
   		<a href="logout.php" class="navbar-brand d-flex align-items-center-end "style="float:right">Se déconnecter</a>
    	<a href="account.php" class="navbar-brand d-flex align-items-center-end"style="float:right">Profil</a>
    	<a href="modif.php" class="navbar-brand d-flex align-items-center-end"style="float:right">Gestion du compte</a>
    	<?php else:  ?>
    	<a href="login.php" class="navbar-brand d-flex align-items-center-end"style="float:right">>Se connecter</a>
       	<a href="register.php" class="navbar-brand d-flex align-items-end"style="float:right">>S'inscrire</a>
   		<?php endif; ?>
    </div>
  </div>
</main>

   <div class="container">
    
    <?php  if(isset($_SESSION['flash'])): ?>
    	<?php foreach($_SESSION['flash'] as $type => $message): ?>
    
    		<div class="alert alert-<?= $type; ?>">
            	<?= $message;  ?>
    		</div>
    	<?php endforeach; ?>
    	<?php  unset($_SESSION['flash']); ?>
   <?php endif; ?>
    