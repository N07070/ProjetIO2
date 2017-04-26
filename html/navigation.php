<nav>
    <?php if ($_SESSION['login']) {?>
        <ul>
            <li><a href="index.php">home</a></li>
            <li><a href="../index.php?page=user">user</a></li>
            <li><a href="../index.php?page=profile">profile</a></li>
            <li><a href="../index.php?page=logout">logout</a></li>
        </ul>
    <?php } else { ?>
        <ul>
            <li><a href="index.php">home</a></li>
            <li><a href="../index.php?page=login">login</a></li>
        </ul>
    <?php }?>
</nav>
