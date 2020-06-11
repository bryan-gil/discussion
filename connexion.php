<?php
$pageSelected = "connexion";
session_start();

var_dump($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/css/page.css">
    <link rel="stylesheet" href="styles/css/fa.css">

</head>
<body class="color">
<!-- Header -->
<header>
    <?php include 'header.php';
    $errors = [];
    if (isset($_POST['submit'])) {
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 15));
        if ($login && $password) {
            $db = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($db, 'discussion');

            $query = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login='$login'");
            $infoUser = mysqli_fetch_array($query);
            if (!password_verify($_POST['password'], $infoUser['password'])) {
                $errors[] = "Mot de passe incorrect !";
            }
            $rows = mysqli_num_rows($query);
            if ($rows == 1 && empty($errors)) {
                $_SESSION['id_utilisateur'] = $infoUser[0];
                header('location:index.php');
            } else {
                echo "Login ou password incorrect";
            }
        } else {
            echo "Veuillez saisir tous les champs.";
        }
    }
    ?>
</header>
<!-- Main -->
<main>
    <div class="block">
        <div class="block-form">
            <h1>Connexion</h1>
            <form method="post" action="connexion.php">
                <p>Login</p>
                <input class="input" type="text" name="login">
                <p>Mot de passe</p>
                <input class="input" type="password" name="password"><br/><br/>
                <input class="input button" type="submit" name="submit" value="Valider"><br/>
            </form>
        </div>
    </div>
    <?= renderError($errors); ?>
</main>
<!-- Footer -->
<footer>
    <?php include 'footer.php' ?>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.poptrox.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
