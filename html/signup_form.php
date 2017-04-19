
<p>
    Your password should match these requirements : <br>
    <ul>
        <li>of at least length 8</li>
        <li>containing at least one lowercase letter</li>
        <li>and at least one uppercase letter</li>
        <li>and at least one number</li>
        <li>and at least a special character (non-word characters)</li>
    </ul>
</p>

<form class="" action="index.php?page=login" method="post" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password_1" placeholder="Password" required><br>
    <input type="password" name="password_2" placeholder="password confirmation" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="file" name="profile_picture" placeholder="Profile Picture" required><br>
    <textarea name="biography" rows="8" cols="40" required>Your biography</textarea><br>
    <input type="hidden" name="options" value="signup_user" required>
    <input type="submit" value="signup">
</form>
