<?php

require_once 'parts/includes.php';

$photos = [];

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $photos = getPhotos($pdo, true);
} else {
    $photos = getPhotos($pdo, false);
}

?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    <?php showImages($photos); ?>
</div>


