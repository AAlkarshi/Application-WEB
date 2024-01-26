<?php

ob_start();

?>

<?php $title = "Home"; ?>

<h1>Accueil</h1>
<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque dolorem cum voluptate quo aut libero animi, odio dolore? Adipisci laboriosam veritatis impedit ipsum ratione eveniet molestias. Magni laboriosam nemo magnam?
Tempora alias cum impedit laudantium minus facere harum iste nostrum quisquam. Modi, expedita quis distinctio iusto, blanditiis tempora at officia facere, accusamus sed ex odit dignissimos necessitatibus ducimus nobis omnis.
Exercitationem a magni vel eligendi, inventore amet quaerat veniam qui. Tempora, quas dicta necessitatibus odit quia placeat illum eveniet, quo architecto ea consequuntur sapiente dolore at earum? Quia, accusamus. Et.
Corrupti optio mollitia nisi asperiores, id excepturi nostrum numquam dolorem dolor. Necessitatibus modi iure culpa blanditiis fugit! Dicta deserunt incidunt placeat ipsum dolores veniam doloribus quia! Repellendus quia provident veritatis?
Dolor officia necessitatibus eum voluptas labore corrupti veniam dolorem numquam atque itaque accusamus laborum consequatur, optio a fuga placeat quia sapiente error ullam perspiciatis omnis reiciendis quos? Ea, id? Nulla!</p>

<?php

// Recupere le contenu et le stocke ds la var $content
	$content = ob_get_clean();

//Recupere le code du fichier 
	require_once "template.php";
	
?>