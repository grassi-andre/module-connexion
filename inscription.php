<?php
//id sql
session_start();
$serveur = "localhost";
$dbname = "andre-grassi_moduleconnexion";
$user = "andre_grassi";
$pass = "andregrassilel";


try{ 
    //Connexion BDD 
    $log = new PDO("mysql:host=$serveur;dbname=$dbname",$user,$pass);
    $log->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// Erreur
catch(PDOException $e){
    echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
}


    @$login = $_POST['login'];
    @$prenom = $_POST['prenom'];
    @$nom = $_POST['nom'];
    @$password = sha1($_POST['password']);

    //htmlspecialchars — Convertit les caractères spéciaux en entités HTML
    //trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
    @$login = htmlspecialchars(trim($login));
    @$prenom = htmlspecialchars(trim($prenom));
    @$nom = htmlspecialchars(trim($nom));
    @$password = htmlspecialchars(trim($password));

    if (isset($_POST['envoi'])){
        if(!empty($_POST['login']) AND !empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['pass']) AND !empty($_POST['confirm'])){
            @$login = htmlspecialchars($_POST['login']);//encodage 
            @$prenom = htmlspecialchars($_POST['prenom']);
            @$nom = htmlspecialchars($_POST['nom']);
            @$password = htmlspecialchars($_POST['password']);
            
        }
        else{
            echo "Remplissez ce champ<br/>";
        }
    } 

    // Verifie si le login est disponnible dans la BDD sinon changer de pseudo
    $sql = "SELECT COUNT(login) AS num FROM utilisateurs WHERE login = :login";
    $stmt = $log->prepare($sql);
    $stmt->bindValue(':login',$login);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['num'] > 0){
          echo "Login deja pris<br/>";
    }
    //LOGIN DEJA PRIS

    elseif(empty($_POST['login']) && empty($_POST['password'])){

    }
    elseif($_POST['password'] !=$_POST['confirm']){
        die("Mot de passe incorrect<br/>");
    }//Si les mdp ne sont pas idendique (die)"mot de pass incorrect et ne crée pas d'utilisateurs dans la bdd
    else{

        $sql1 = "INSERT INTO utilisateurs(login,prenom,nom,password)
        VALUES (:login,:prenom,:nom,:password)";
        $stmt = $log->prepare($sql1);
        $stmt->bindParam(':login' ,$login);
        $stmt->bindParam(':prenom' ,$prenom);
        $stmt->bindParam(':nom' ,$nom);
        $stmt->bindParam(':password' ,$password);
  /*binParam = Identifiant. Pour une requête préparée utilisant des marqueurs nommés, ce sera le nom du paramètre sous la forme :name. Pour une requête préparée utilisant les marqueurs interrogatifs, ce sera la position indexé +1 du paramètre.*/
        //if(empty($_POST['login']) && empty($_POST['password'])){
            //die();
        //}
        if($stmt->execute()){
            echo "Bienvenue<br/>";
        }
        else{
            $error = "Erreur: "; $e->getMessage();
        }
        
        
        }

?>
<link rel="stylesheet" href="style.css">
<div class="inscription">
<form name="inscription" method="POST" action="" align="center">
<fieldset>
    <legend><h2>Inscription</h2></legend>
    Login<br>
    <input type="text" name="login" value="" autocomplete="off" required><br>
    Prenom<br>
    <input type="text" name="prenom" value="" autocomplete="off" required><br>
    Nom<br>
    <input type="text" name="nom" value="" autocomplete="off" required><br>
    Mot de passe<br>
    <input type="password" name="password" value="" autocomplete="off" required><br>
    Confirmation de mot de passe<br>
    <input type="password" name="confirm" value="" autocomplete="off" required><br>
    <br/><br/>
    <input type="submit" name="envoi">

</fieldset>
</form>
</div>
<div class="codeco">
<a href="index.php">Accueil</a>
</div>
<div class="deco">
<a href="deconnexion.php">Déconnexion</a>
</div>

