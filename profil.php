<?php
$pageSelected = "profil";

include 'header.php';
$errors = [];
$request = " SELECT * FROM utilisateurs WHERE id = '" . $_SESSION['id_utilisateur'] . "'";
$query = mysqli_query($db, $request);
$infoUser = mysqli_fetch_array($query);

if (!empty($_POST)) {
    $login = htmlspecialchars($_POST['login']);
    if (!password_verify($_POST['old_password'], $infoUser['password'])) {
        $errors[] = "Mot de passe incorrect !";
    }
    $requestTest = "SELECT * FROM utilisateurs WHERE login = '" . $login . "' AND login != '" . $infoUser['login'] . "'";
    $query = mysqli_query($db, $requestTest);
    $loginTest = mysqli_fetch_array($query);
    $password_required = preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,16}$^", $_POST['password']);
    if (!$password_required && !empty($_POST['password'])) {
        $errors[] = "Le mot de passe doit contenir entre 8 et 16 caractères dont: une majuscule, une minuscule, un chiffre et un caractère spécial.";
    }
    if (!empty($loginTest)) {
        $errors[] = "le pseudo doit être unique !";
    }
    if (!empty($_POST['password']) && $_POST['password'] != $_POST['conf_password']) {
        $errors[] = "Le mot de passe ne correspond pas ! ";
    }
    if (empty($login)) {
        $errors[] = "Il faut un login !";
    }

    $login_required = preg_match("/^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d\.\-\_\ \|]{4,24}$/", $login);
    if (!$login_required) {
        $errors[] = "Le login doit : <br>- contenir entre 4  et 24 caractères<br>- ne doit pas contenir de caractères spéciaux (sauf: . , - , _ , espace et | ).";
    }
    if (empty($errors)) {
        $requestUpdate = "UPDATE utilisateurs SET ";
        $set = [];
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 15));
            $set[] = "password = '" . $password . "'";
        }
        if ($infoUser['login'] != $login) {
            $set[] = "login = '" . $login . "'";
        }

        if (!empty($set)) {
            $output = implode(' , ', $set);
            $requestUpdate .= $output . " WHERE id = " . $_SESSION['id'];
            mysqli_query($db, $requestUpdate);
            header('location: profil.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="styles/css/page.css">
    <link rel="stylesheet" href="styles/css/fa.css">
</head>
<body>
<header>
</header>
<main>
    <div class="block">
        <div class="block-form">
            <h1>Votre Profil</h1>
            <form action="profil.php" method="post">
                <dl class="form--input first">
                    <dt>
                        <div class="block-form-label">
                            <label class="form-label" for="login">Login</label>
                        </div>
                    </dt>
                    <dd>
                        <input type="text" name="login" value="<?= $infoUser['login'] ?>" maxlength="255" id="login"
                               class="input">
                    </dd>
                </dl>
                <dl class="form--input">
                    <dt>
                        <div class="block-form-label">
                            <label class="form-label" for="old_password"> Old Password</label>
                            <dfn class="form-hint">Requis</dfn>
                        </div>
                    </dt>
                    <dd>
                        <input type="password" id="old_password" name="old_password" maxlength="255" required="required"
                               class="input">
                    </dd>
                </dl>
                <dl class="form--input">
                    <dt>
                        <div class="block-form-label">
                            <label class="form-label" for="password">Password</label>
                        </div>
                    </dt>
                    <dd>
                        <input type="password" id="password" name="password" maxlength="255" class="input">
                    </dd>
                </dl>
                <dl class="form--input">
                    <dt>
                        <div class="block-form-label">
                            <label class="form-label" for="conf_password">Confirmation password</label>
                        </div>
                    </dt>
                    <dd>
                        <input type="password" id="conf_password" name="conf_password" class="input">
                    </dd>
                </dl>
                <div class="form-submit">
                    <button type="submit" class="button"><i class="far fa-save"></i> Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</main>
<footer>
    <?php include 'footer.php'?>
</footer>

</body>
</html>