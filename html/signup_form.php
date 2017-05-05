
<div id='signup_form' class='card'>
    <br>
    <p> Ton mot de passe doit : faire 8 caractères de long, contenir une minuscule et une majuscule, un chiffre et un caractère non-alphabétique.</p>
    <br>
<form action="index.php?page=login" method="post" enctype="multipart/form-data">
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
        <textarea name="biography" rows="8" cols="40" required>Parle de toi, raconte ta vie.</textarea><br>
        <span class="highlight"></span>
        <span class="bar"></span>
    </div>


    <input type="hidden" name="options" value="signup_user" required>

    <div class="group">
        <input type="submit" value="signup">
        <span class="highlight"></span>
        <span class="bar"></span>
    </div>

</form>
