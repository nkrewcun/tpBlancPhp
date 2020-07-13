<?php

function getUserByPseudo($pdo)
{

    $query = $pdo->prepare('SELECT * FROM utilisateur WHERE pseudo=:pseudo');
    $query->execute([
        'pseudo' => $_POST['pseudo']
    ]);
    return $query;

}

function addToDb($pdo)
{
    $query = $pdo->prepare('INSERT INTO utilisateur(pseudo, email, prenom, nom, password)
VALUES(:pseudo, :email, :prenom, :nom, :password)');
    $query->execute([
        'pseudo' => $_POST['pseudo'],
        'email' => $_POST['email'],
        'prenom' => $_POST['prenom'],
        'nom' => $_POST['nom'],
        'password' => md5($_POST['password'])
    ]);
}

function connectUser($pdo) {
    $errors = [];
    $query = $pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :pseudo AND password = :password');
    $query->execute([
        'pseudo' => $_POST['pseudo'],
        'password' => md5($_POST['password'])
    ]);
    $res = $query->fetch();
    if($res) {
        $_SESSION['user'] = $res;
    } else {
        $errors[] = "Erreur de login/password";
    }
    return $errors;

}

function validateLoginForm() {
    $errors = [];
    if(empty($_POST['pseudo'])) {
        $errors[] = 'Le pseudo est requis';
    }
    if(empty($_POST['password'])) {
        $errors[] = "Le mot de passe est requis";
    }
    return $errors;
}

function validateRegisterForm($pdo) {
    $errors = [];
    if (empty($_POST['pseudo'])) {
        $errors[] = 'Le pseudo est requis';
    } else {
        if (getUserByPseudo($pdo)->fetch()) {
            $errors[] = "Le pseudo existe déjà";
        }
    }
    if (empty($_POST['email'])) {
        $errors[] = 'L\'adresse email est requise';
    } else if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email'])) {
        $errors[] = "Le format de l'email est invalide";
    }
    if (empty($_POST['prenom'])) {
        $errors[] = 'Le prénom est requis';
    }
    if (empty($_POST['nom'])) {
        $errors[] = 'Le nom est requis';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Le mot de passe est requis';
    } else if($_POST['password'] !== $_POST['passwordConfirm']) {
        $errors[] = 'La confirmation du mot de passe est fausse';
    }

    return $errors;
}

function displayErrors($errors)
{
    if (count($errors) != 0) {
        echo(' <h2>Erreurs lors de la dernière soumission du formulaire : </h2>');
        foreach ($errors as $error) {
            echo('<div class="error">' . $error . '</div>');
        }
    }
}
