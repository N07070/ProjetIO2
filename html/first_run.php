<div class="card">
    <?php if(!$_SESSION['login']) { ?>
        <h1>Bienvenue !</h1>

        <p>Vous voici donc sur la page d'acceuil. Il semble qu'il n'y ai aucun projet, pour le moment.</p>

        <p>Mais au fait ? Qu'es ce que c'est que ce site ? Hé bien c'est simple : vous
        avez un projet, comme construire une cabane, partir en vacances, ou faire du
        street art, mais vous ne savez pas avec qui le faire. Ou simplement, vous avez
        du temps libre et vous souhaitez vous impliquer dans un projet ? Hé bien, alors
        vous êtes au bon endroit !</p>

        <p>C'est là L'essence de Fait Le Avec des Potes !</p>

        <p>Avec <b>FLAP</b>, vous allez pouvoir faire tout cela...</p>

        <p>Pour commencer, créez-vous un compte en cliquant sur
            <i style="font-size: 1em;" class="material-icons">perm_identity</i> dans la navigation, en haut de la page. </p>
    <?php } else { ?>

        <h2> Tu viens de créer un compte. Bravo !</h3>

            <p>Maintenant, ajoute ton premier projet en cliquant sur <i style="font-size: 1em;" class="material-icons">account_circle</i> </p>

            <p>Tu peux aussi faire des recherches parmis les autres projets avec <i style="font-size: 1em;" class="material-icons">search</i>.</p>

            <p>En espérant que tu puisse mener à terme ce que tu fait !</p>

            <small>Bonne chance !</small>
    <?php } ?>
</div>
