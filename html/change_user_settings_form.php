<form class="" action="index.php?page=user&options=4" method="post">

    <h2>Mettre à jour mes informations</h2>

    <br>
        <small> Ton mot de passe doit : faire 8 caractères de long, contenir une minuscule et une majuscule, un chiffre et un caractère non-alphabétique.</small>
    <br>
    <br>

    <div class="group">
        <input type="password" name="old_password" autofocus required><br>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Vieux mot de passe</label>
    </div>

    <div class="group">
        <input type="password" name="password_1" required><br>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Mot de passe</label>
    </div>

    <div class="group">
        <input type="password" name="password_2"  required><br>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Mot de passe (Confirmation)</label>
    </div>


    <div class="group">
        <input type="email" name="email" value="<?php echo($user[0]['email']); ?>"required><br>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Courriel</label>
    </div>

    <!-- <p>Photo de profil</p>
    <input type="file" name="profile_picture" placeholder="Profile Picture" required><br> -->

    <div class="group">
        <textarea name="biography" rows="8" cols="40" required><?php echo($user[0]['biography']); ?></textarea><br>
        <span class="highlight"></span>
        <span class="bar"></span>
    </div>


    <input type="hidden" name="change_user_settings" value="true" required>

    <div class="group">
        <input type="submit" value="Mettre à jour mes informations">
        <span class="highlight"></span>
        <span class="bar"></span>
    </div>
</form>
