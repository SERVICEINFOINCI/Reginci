<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="/REGINCI/bootstrap-5.1.3-dist/css/style local.css" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     </head>
</head>

<body>
    <?php
  /*require('CONNEXION.php');*/
    /*require('connexion_reginci.php');*/

 
// Initialisation des variables
 
$errors = array();
 
// Connexion à la base de données

    if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password1'], $_REQUEST['password2']))
 {
    $username = stripslashes($_REQUEST['username']);
    $email = stripslashes($_REQUEST['email']);
    $password1 = stripslashes($_REQUEST['password1']);
    $password2 = stripslashes($_REQUEST['password2']);
 
    // Validation on s'assurer que le formulaire est correctement remplit
    // en ajoutant (array_push ()) l'erreur correspondante au tableau $ errors
 
    if ($password1 != $password2) 
    {
    array_push($errors, "Les deux mots de passe ne correspondent pas");
    }
 
 
    // on vérifie d'abord la base de données pour s'assurer
    // que l'utilisateur n'existe pas déjà avec le même nom d'utilisateur et / ou email
 
    $req = $dbco->prepare('SELECT * FROM users where username=? and email=? and password=?');
    $req->execute(array(
    $_POST['username'],
    $_POST['email'],
    $_POST['password1']));
     
    $resultat = $req->fetch();
 
    if (!$resultat)
    {
        if (!$resultat['username'] == $username) 
        {
        array_push($errors, "Ce nom d'utilisateur existe déjà");
        }
    
        if (!$resultat['email'] == $email)
        
         {
        array_push($errors, "l'email existe déjà");
        }
        if (!$resultat['password1'] == $password1) {
        array_push($errors, "le mot de passe existe déjà");
        }
    }
 
    // Finalement, on enregistre l'utilisateur s'il n'y a pas d'erreur dans le formulaire  
 
    if (count($errors) == 0)
    {
     $password = md5($password1);
 
      $util = $dbco->prepare("INSERT INTO users(username, email, type, password)
        VALUES(?, ?, ?, ?)");
        $util->execute(array($username, $email, 'user', $password));

            echo "<div class='sucess'>
             <h3>Vous êtes inscrit avec succès.</h3>
             <p>Cliquez ici pour vous <a href='login_exist.php'>connecter</a></p>
       </div>";
        }}
    ?>
        <form class="box" action="" method="post">
            <h1 class="box-logo box-title">
                GESTION DES GUICHETS DANS LES TRESORERIES GENERALES DE CÔTE D'IVOIRE </h1>
            <div class="container">
            <h1>Menu principal</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item">
                      <a class="nav-link" href="formulaire_achat_produit_new.php">Nouvelle vente</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="formulaire_articles_new.php"> Gestion des articles</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Entrée en stock</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Sortie de stock</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Niveau de stock</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="formulaire_recette_new.php">Rapport de vente</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Edition inventaire</a>
                    </li>
                </ul>
            </nav>
            </div>

            <input type="submit" name="submit" value="Fermer" class="box-button" />           
        </form>
</body>

</html>