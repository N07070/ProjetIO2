<nav class="primary_background">
    <?php if ($_SESSION['login']) {?>
        <ul>
            <li><a href="index.php"><i class="material-icons">home</i></a></li>
            <li><a href="../index.php?page=user"><i class="material-icons">account_circle</i></a></li>
            <li><a href="../index.php?page=search"><i class="material-icons">search</i></a></li>
            <li><a href="../index.php?page=logout"><i class="material-icons">launch</i></a></li>
        </ul>
    <?php } else { ?>
        <ul>
            <li><a href="index.php"><i class="material-icons">home</i></a></li>
            <li><a href="../index.php?page=login"><i class="material-icons">perm_identity</i></a></li>
            <li><a href="../index.php?page=search"><i class="material-icons">search</i></a></li>
        </ul>
    <?php }?>
</nav>
