<?php

require_once 'parts/includes.php';

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateLoginForm($pdo);
    if (count($errors) === 0) {
        $errors = connectUser($pdo);
        if (!$errors) {
            header("Location: dashboard.php");
        }
    }
}

?>

    <h2>Connexion : </h2>
    <div class="container">
        <form method="post" action="login.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pseudo">Login / Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo"/>

                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password"/>
            </div>

            <input type="submit" placeholder="Connexion"/>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php
require_once 'parts/footer.php';
