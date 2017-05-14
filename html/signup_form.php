
<div id='signup_form' class='card'>
    <h2>S'inscrire</h2>
    <form action="index.php?page=login" method="post" enctype="multipart/form-data">
        <div class="group">
            <input type="text" maxlength="20" name="username" required><br>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Nom d'utilisateur</label>
        </div>

        <br>
            <small> Ton mot de passe doit : faire 8 caractères de long, contenir une minuscule et une majuscule, un chiffre et un caractère non-alphabétique.</small>
        <br>
        <br>

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
            <input type="email" name="email"required><br>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Courriel</label>
        </div>

        <p>Photo de profil</p>
        <input type="file" name="profile_picture" placeholder="Profile Picture" required><br>

        <div class="group">
            <textarea name="biography" rows="8" maxlength="499" cols="40" required>Ta biographie : parle de toi, raconte ta vie.</textarea><br>
            <span class="highlight"></span>
            <span class="bar"></span>
        </div>


        <input type="hidden" name="options" value="signup_user" required>

        <div class="group">
            <input type="submit" value="S'inscrire">
            <span class="highlight"></span>
            <span class="bar"></span>
        </div>

    </form>
</div>
