<?php

function getPhotos($pdo, $isConnected)
{
    if ($isConnected) {
        $query = $pdo->prepare('SELECT * FROM photo');
        $query->execute();
    } else {
        $query = $pdo->prepare('SELECT * FROM photo WHERE isPublic=1');
        $query->execute();
    }
    return $query;
}

function getMyPhotos($pdo) {
    $query = $pdo->prepare('SELECT * FROM photo WHERE nom_prenom_utilisateur=:nom_prenom_utilisateur');
    $query->execute([
        'nom_prenom_utilisateur' => $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom']
    ]);
    return $query;
}

function addImageToDb($pdo, $fileName, $isPublic)
{
    $query = $pdo->prepare('INSERT INTO photo(file_name, lieu_publi, date_publication, nom_prenom_utilisateur, isPublic)
VALUES(:file_name, :lieu_publi, :date_publication, :nom_prenom_utilisateur, :isPublic)');
    $query->execute([
        'file_name' => $fileName,
        'lieu_publi' => 'test',
        'date_publication' =>  date("Y-m-d H:i:s"),
        'nom_prenom_utilisateur' => $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'],
        'isPublic' => $isPublic ? 1 : 0
    ]);
}

function validateImageForm()
{
    $errors = [];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        if ($_FILES['image']['size'] <= 8000000) {
            $extensionFile = $_FILES['image']['type'];
            $authorizedExtensions = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($extensionFile, $authorizedExtensions)) {
                $errors[] = 'Je n\'accepte que des images';
            }

        } else {
            $error[] = 'le fichier est trop lourd pour un petit serveur ... ';
        }
    } else {
        $errors[] = 'Une image est requise';
    }

    return $errors;
}

function showImages($photos) {
    foreach ($photos->fetchall() as $photo) {
        echo '<div class="col mb-4">
        <div class="card h-100">
            <img src="assets/images/' . $photo['file_name'] . '" class="card-img-top" alt="' . $photo['file_name'] . '">
        </div>
    </div>';
    }
}