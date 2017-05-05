<div id='login_form' class='card'>
    <br>
    <form action="index.php?page=login" method="post">
        <div class="group">
            <input type="text" name="username" required><br>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Nom d'utilisateur</label>
        </div>

        <div class="group">
            <input type="password" name="password_1" required><br>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Nom d'utilisateur</label>
        </div>

        <input type="hidden" name="options" value="login_user">

        <div class="group">
            <input type="submit" value="Se Connecter">
            <span class="highlight"></span>
            <span class="bar"></span>
        </div>

    </form>
</div>
