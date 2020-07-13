<?php

require_once 'parts/includes.php';

$photos = [];

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $photos = getPhotos($pdo, true);
} else {
    $photos = getPhotos($pdo, false);
}

showImages($photos);

require_once 'parts/footer.php';
