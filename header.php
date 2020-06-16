<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'discussion');
if (in_array($pageSelected,['profil','discussion']) && !$_SESSION['id_utilisateur']) {
    header('location: connexion.php');
}
if (in_array($pageSelected, ['connexion', 'inscription']) && isset($_SESSION['id_utilisateur'])) {
    header('location: index.php');
}
$infoUser = [];
if (isset($_SESSION['id_utilisateur'])){
    $request = " SELECT login FROM utilisateurs WHERE id = '" . $_SESSION['id_utilisateur'] . "'";
    $query = mysqli_query($db, $request);
    $infoUser = mysqli_fetch_array($query);

}
/**
 * @param $errors
 * @return string
 */
function renderError($errors)
{
    if (!empty($errors)) {
        $output = "";
        if (count($errors) > 1) {
            $output .= "<ul>";
            foreach ($errors as $error) {
                $output .= "<li>" . $error . "</li>";
            }
            $output .= "</ul>";
        } else {
            $output = $errors[0];
        }
        return "<div class=\"blockMessage blockMessage--error block-rowMessage--iconic\">"
            . $output .
            "</div>";
    } else {
        return "";
    }
}

?>
<nav>
    <div class="navbar">
        <div class="logo">

            <a href="index.php">   <i class="fas fa-mug-hot"></i> </a>

        </div>
        <div class="link">
            <ul>
                <li class="nav-link<?= $pageSelected == "index" ? " is-selected" : ""; ?>">
                    <a href="index.php"><i class="far fa-home"></i> Accueil</a>
                </li>

                <?php if (!isset($_SESSION['id_utilisateur'])) { ?>
                    <li class="nav-link<?= $pageSelected == "connexion" ? " is-selected" : ""; ?>">
                        <a href="connexion.php"><i class="far fa-sign-in-alt"></i> Connexion</a>
                    </li>
                    <li class="nav-link<?= $pageSelected == "inscription" ? " is-selected" : ""; ?>">
                        <a href="inscription.php"><i class="far fa-key"></i> Inscription</a>
                    </li>

                <?php } else { ?>
                    <li class="nav-link<?= $pageSelected == "discussion" ? " is-selected" : ""; ?>">
                        <a href="discussion.php"><i class="far fa-book"></i> Discussion</a>
                    </li>
                    <li class="nav-link<?= $pageSelected == "profil" ? " is-selected" : ""; ?>">
                        <a href="profil.php"><i class="far fa-user"></i> <?= $infoUser['login'] ?></a>
                    </li>
                    <li class="nav-link">
                        <a href="delete_session.php"><i class="far fa-sign-out-alt"></i>Deconnexion</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>

</nav>
