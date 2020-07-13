<?php

require_once 'parts/includes.php';

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$photos = [];
$photos = getMyPhotos($pdo);

?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    <?php showImages($photos);
    ?>
</div>

?>
