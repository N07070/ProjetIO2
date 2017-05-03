<nav>
    <?php if ($_SESSION['login']) {?>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="../index.php?page=user">Paramètres</a></li>
            <li><a href="../index.php?page=profile">Page de profile</a></li>
            <li><a href="../index.php?page=logout">Se déconnecter</a></li>
        </ul>
    <?php } else { ?>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="../index.php?page=login">Se connecter</a></li>
        </ul>
    <?php }?>
</nav>
