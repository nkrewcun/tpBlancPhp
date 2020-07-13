<?php

require_once 'parts/includes.php';

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$photos = [];
$photos = getUserPhotos($pdo);

showImages($photos);

require_once 'parts/footer.php';
