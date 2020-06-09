
<div class="footer-conteneur">
    <ul>
        <li>
            <a href="index.php">
                <i class="far fa-home"></i>
            </a>
        </li>
        <?php if(!isset($_SESSION['id'])) { ?>
            <li>
                <a href="connexion.php">
                    <i class="far fa-sign-in-alt"></i>
                </a>
            </li>
            <li>
                <a href="inscription.php">
                    <i class="far fa-key"></i>
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="profil.php">
                    <i class="far fa-user"></i>
                </a>
            </li>
            <li>
                <a href="delete_session.php">
                    <i class="far fa-sign-out-alt"></i>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>