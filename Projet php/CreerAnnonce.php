<?php

require_once 'inc/functions.php';
session_start();
if(!empty($_POST)){

    $errors = array();

    require_once 'inc/db.php';
	
	$etat = "en ligne";

    if(empty($_POST['title'])  || !preg_match("/^[a-zA-Z0-9_' ]*$/" , $_POST['title'])){
        $errors['title'] = "Vous n'avez pas entré de titre valide";
    }
	
	if(empty($_POST['CoutLoyer'])){
    	$etat = "En cours";
    	$_POST['CoutLoyer'] = '1';
    }else{
    	if(!preg_match('/^[0-9 ]+$/' , $_POST['CoutLoyer'])){
        	$errors['CoutLoyer'] = "Vous n'avez pas entré de coût valable";
        }
    }

	if(empty($_POST['CoutCharges'])){
    	$etat = "En cours";
    	$_POST['CoutCharges'] = '1';
    }else{
    	if(!preg_match('/^[0-9 ]+$/' , $_POST['CoutCharges'])){
        	$errors['CoutCharges'] = "Vous n'avez pas entré de coût valable";
        }
    }
	

	if(empty($_POST['typechauffage'])){
    	$etat = "En cours";
    	$_POST['typechauffage'] = ' ';
    }else{
    	if(!preg_match('/^[a-zA-Z ]+$/' , $_POST['typechauffage'])){
        	$errors['typechauffage'] = "Vous n'avez pas entré de type valide";
        }
    }

	if(empty($_POST['Superficie'])){
    	$etat = "En cours";
    	$_POST['Superficie'] = '1';
    }else{	
		if(!preg_match('/^[0-9 ]+$/' , $_POST['Superficie'])){
        	$errors['Superficie'] = "Vous n'avez pas entré une superficie valable";
        }
    }
             
    if(empty($_POST['Description'])){
    	$etat = "En cours";
    	$_POST['Description'] = ' ';
    }
       
	if(empty($_POST['Adresse'])){
    	$etat = "En cours";
    	$_POST['Adresse'] = ' ';
    }else{    
    	if(!preg_match("/^[a-zA-Z0-9_' ]*$/", $_POST['Adresse'])){
        	$errors['Adresse'] = "Vous n'avez pas entré d'adresse valide";
        }
    }

	if(empty($_POST['Ville'])){
    	$etat = "En cours";
    	$_POST['Ville'] = ' ';
    }else{
    	if(!preg_match('/^[a-zA-Z ]+$/' , $_POST['Ville'])){
        	$errors['Ville'] = "Vous n'avez pas entré de nom valide";
    	}
    }
       
	if(empty($_POST['CP'])){
    	$etat = "En cours";
    	$_POST['CP'] = '11111';
    }else{
    	if(!preg_match('/^[0-9 ]{5}+$/' , $_POST['CP'])){
        	$errors['CP'] = "Vous n'avez pas entré un code postal valable";
        }
    }
       
    if(empty($_POST['IdEnergie'])){
    	$etat = "En cours";
    	$_POST['IdEnergie'] = '1';
    }else{
    	if(!preg_match('/^[0-9 ]+$/' , $_POST['IdEnergie'])){
        	$errors['IdEnergie'] = "Vous n'avez pas entré un id  valable";
    	}
    }
    if(empty($_POST['IdPhoto'])){
    	$etat = "En cours";
        $_POST['IdPhoto'] = '1';
    }else{
    	if(!preg_match('/^[0-9 ]+$/' , $_POST['IdPhoto'])){
        	$errors['IdPhoto'] = "Vous n'avez pas entré un id  valable";
    	}
    }
      
	if(empty($_POST['TypeMaison'])){
    	$etat = "En cours";
    	$_POST['TypeMaison'] = '1';
    }else{
    	if(!preg_match('/^[1-6]{1}+$/' , $_POST['TypeMaison'])){
        	$errors['TypeMaison'] = "Vous n'avez pas entré un type valable";
    	}
    }

    if(empty($errors)){
        $req = $dbh->prepare("INSERT INTO T_annonce SET titre = ?,cout_loyer = ?, cout_charges = ?, type_chauffage = ?,
        superficie = ?, description = ?, adresse = ?, ville = ?, cp = ?, etat_annonce = ?, e_id_energie = ?, p_idphoto = ?
        ,T_type = ?, u_id = ?");
        $req->execute([$_POST['title'],$_POST['CoutLoyer'],$_POST['CoutCharges'],$_POST['typechauffage'],
        $_POST['Superficie'],$_POST['Description'],$_POST['Adresse'],$_POST['Ville'],$_POST['CP'],$etat,$_POST['IdEnergie'],$_POST['IdPhoto'], 
        $_POST['TypeMaison'], $_SESSION['auth']->u_id]);
    	$_SESSION['flash']['success'] = "Votre annonce a été créé";
    	header ('location: account.php');
    	exit();
    }
    
}
?>

<?php require 'inc/header.php'; ?>

<h1> Créer votre annonce </h1>

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
        <label for=""> Titre </label>
        <input type="text" name="title" class="form-control"/>
    </div>
   
	<div class="form-group">
        <label for=""> Coût loyer </label>
        <input type="number" name="CoutLoyer" class="form-control" />
    </div>
	
	<div class="form-group">
        <label for=""> Coût Charges </label>
        <input type="number" name="CoutCharges" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Type de Chauffage </label>
        <input type="text" name="typechauffage" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Superficie </label>
        <input type="number" name="Superficie" class="form-control" />
    </div>

    <div class="form-group">
        <label for=""> Description </label>
        <input type="text" name="Description" class="form-control" />
    </div>

	<div class="form-group">
        <label for=""> Adresse </label>
        <input type="text" name="Adresse" class="form-control" />
    </div>

	<div class="form-group">
        <label for=""> Ville </label>
        <input type="text" name="Ville" class="form-control" />
    </div>

	<div class="form-group">
        <label for=""> Code Postal </label>
        <input type="number" name="CP" class="form-control" />
    </div>

	<div class="form-group">
        <label for=""> Catégorie énergie </label>
        <input type="number" name="IdEnergie" class="form-control" />
    </div>

	<div class="form-group">
        <label for="">	Id Photo</label>
        <input type="number" name="IdPhoto" class="form-control" />
    </div>

	<div class="form-group">
        <label for=""> Type Maison </label>
        <input type="number" name="TypeMaison" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary"> Valider </button>

</form>

<?php require 'inc/footer.php'; ?>