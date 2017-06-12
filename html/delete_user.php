<form action="index.php?page=user&options=5" method="post">

    <h2>Supprimer mon compte</h2>
    <br>

    <div class="group">
        <input type="password" name="password" autofocus required><br>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Mot de passe</label>
    </div>

    <?php display_error("Est-tu sûr de vouloir supprimer ton compte ? Toutes tes données seront effacées, et tu perdra le contrôle de tes projets."); ?>

    <div class="group">
        <input class="error" type="submit" value="Supprimer mon compte">
        <span class="highlight"></span>
        <span class="bar"></span>
    </div>
</form>
