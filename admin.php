<?php
$bdd = new PDO('mysql:host=localhost;dbname=andre-grassi_moduleconnexion;charset=utf8', 'andre_grassi', 'andregrassilel');
if(isset($_GET['type']) AND $_GET['type'] == 'utilisateurs') {
   if(isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
      $confirme = (int) $_GET['confirme'];
      $req = $bdd->prepare('UPDATE utilisateurs SET confirme = 1 WHERE id = ?');
      $req->execute(array($confirme));
   }
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
      $req->execute(array($supprime));
   }

}
$utilisateurs = $bdd->query('SELECT * FROM utilisateurs ORDER BY id DESC LIMIT 0,5');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Admin</title>
</head>
<body>

   <ul>
      <?php while($m = $utilisateurs->fetch()) { ?>
      <li><?= @$m['id'] ?> : <?= @$m['login'] ?><?php if(@$m['confirme'] == 0) { ?> - <a href="admin.php?type=utilisateurs&confirme=<?= @$m['id'] ?>">Confirmer</a><?php } ?> - <a href="admin.php?type=utilisateurs&supprime=<?= @$m['id'] ?>">Supprimer</a></li>
      <?php } ?>
   </ul>
   <br /><br />
   <div class="admin">
   <form methode=post action="connexion.php">
<input type="submit" name="connexion" value="connexion">
</form>
<br>
<form action="inscription.php">
<input type="submit" name="inscription" value="inscription">

<a href="deconnexion.php">Déconnexion</a>
<a href="profil.php">Profil</a>
</div>
</body>
</html>