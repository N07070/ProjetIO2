<?php
require_once("Utilisateur.php");

$user_data = display_user("n07070@admin.com");

require_once("../html/header.php");

if($_SESSION['login']){
?>

<h1><?php echo($user_data[0]['username']);?></h1>
<?php echo("<img src='uploads/".$user_data[0]['profile_picture']."'>");?>
<ul>
    <li><?php echo($user_data[0]['uuid']);?></li>
    <li><?php echo($user_data[0]['email']);?></li>
    <li><?php echo($user_data[0]['password']);?></li>
    <li><?php echo($user_data[0]['']); ?></li>
</ul>

<?php }

require("../html/footer.php");

?>
