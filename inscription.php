<?php
$pageSelected = "inscription";
if (isset($_POST['submit'])) {
    $login = htmlentities(trim($_POST['login']));
    $password = htmlentities(trim($_POST['password']));
    $repeatpassword = htmlentities(trim($_POST['repeatpassword']));

    if ($login && $password && $repeatpassword) {
        if ($password == $repeatpassword) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 15));
            $db = mysqli_connect('localhost', 'root', '') or die('Erreur');
            mysqli_select_db($db, 'discussion');

            $query = mysqli_query($db, "INSERT INTO utilisateurs (login, password) VALUES('$login', '$password');");

            die("Inscription terminée. <a href='connexion.php'>Connectez-vous</a>.");
        } else {
            echo "Les mots de passes doivent être identiques";
        }
    } else {
        echo "Veuillez saisir tous les champs";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles/css/page.css">
    <link rel="stylesheet" href="styles/css/fa.css">
</head>
<body class="color">
<!-- Header -->
<header>
    <?php include 'header.php' ?>
</header>
<!-- Main -->
<main>
    <div class="block">
        <div class="block-form">
            <h1>Inscription</h1><br/>
            <form method="post" action="inscription.php">
                <p>Login</p>
                <input class="input" type="text" name="login">
                <p>Mot de passe</p>
                <input class="input" type="password" name="password">
                <p>Répétez votre mot de passe</p>
                <input class="input" type="password" name="repeatpassword"><br><br>
                <input class="input button" type="submit" name="submit" value="Valider">
            </form>
        </div>
    </div>
</main>
<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.poptrox.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<footer>
    <?php include 'footer.php' ?>
</footer>
</body>
</html>
