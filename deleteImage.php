<?php

require_once 'parts/includes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}

$id = $_GET['id'];
$result = getPhotoById($pdo, $id);
$res = $result->fetch();
if (!$res) {
    header('Location: index.php');
}

if($res['nom_prenom_utilisateur'] === $_SESSION['user']['pseudo']) {
    deleteImageFromDb($pdo, $id);
    unlink('assets/images/' . $res['file_name']);
}

$result->closeCursor();
header('Location: dashboard.php');

require_once 'parts/footer.php';
