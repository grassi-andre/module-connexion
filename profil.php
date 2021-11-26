<?php


session_start();  //start session
$bdd = new PDO('mysql:host=localhost;dbname=andre-grassi_moduleconnexion','andre_grassi',"andregrassilel");  // connexion a la BDD

if(isset($_SESSION['id'])){ 
    $requser = $bdd->prepare("SELECT * FROM utlisitateurs WHERE id = ?");
    $requser->execute(array($_SESSION['id']));//parcours le tableau 
   $user = $requser->fetch();//recup la ligne suivante d'un jeu de resultats 

   if(isset($_POST['newlogin']) AND !empty($_POST['newlogin']) AND $_POST['newlogin'] != $user['login'])//si newlogin existe et que il n'est pas vide et newlogin est diff de login  
		{
			$newlogin = htmlspecialchars($_POST['newlogin']);//je crée une variable a insérer 
			$insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");//prepa de la requete sql
			$insertlogin->execute(array($newlogin, $_SESSION['id']));//exe de la requete
			header('Location: profil.php?id='.$_SESSION['id']);//redirction
   }
   if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom'])//si newprenom existe et que il n'est pas vide et newprenom est diff de prenom  
		{
			$newprenom = htmlspecialchars($_POST['newprenom']);//je crée une variable a insérer 
			$insertprenom = $bdd->prepare("UPDATE utilisateurs SET prenom = ? WHERE id = ?");//prepa de la requete sql
			$insertprenom->execute(array($newlogin, $_SESSION['id']));//exe de la requete
			header('Location: profil.php?id='.$_SESSION['id']);//redirction
   }
   if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom'])//si newnom existe et que il n'est pas vide et newnom est diff de nom  
		{
			$newnom = htmlspecialchars($_POST['newnom']);//je crée une variable a insérer 
			$insertnom = $bdd->prepare("UPDATE utilisateurs SET nom = ? WHERE id = ?");//prepa de la requete sql
			$insertnom->execute(array($newlogin, $_SESSION['id']));//exe de la requete
			header('Location: profil.php?id='.$_SESSION['id']);//redirction
   }
   
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
    $mdp1 = sha1($_POST['newmdp1']);
    $mdp2 = sha1($_POST['newmdp2']);
    if($mdp1 == $mdp2) {
       $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
       $insertmdp->execute(array($mdp1, $_SESSION['id']));
       header('Location: profil.php?id='.$_SESSION['id']);
    } else {
       $msg = "Vos deux mdp ne correspondent pas !";
    }
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profil</title>
</head>
<body>
    
<div class="profil">
<fieldset>
<form action="" method="POST">
<label for="login">Login</label><br>
<input type="text" name="newlogin" placeolder="login" value="<?php echo @$_SESSION['login'] ?>" /><br /><br />
<label for="prenom">Prenom</label><br>
<input type="text" name="newprenom" placeolder="prenom" value="<?php echo @$_SESSION['prenom'] ?>" /><br /><br />
<label for="nom">Nom</label><br>
<input type="text" name="newnom" placeolder="nom"> <br /><br />
<label for="password">Mot de passe</label><br>
<input type="password" name="newmdp1" placeolder="password"> <br /><br />
<label for="password">Confirmation mot de passe</label><br>
<input type="password" name="newmdp2" placeolder="password2"> <br /><br />
<input type="submit" value="Mettre à jour mon profil !" /> <br /><br />
</form>
</fieldset>
</body>
</div>
</html>