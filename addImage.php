<?php

require_once 'parts/includes.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateImageForm();
    if (count($errors) === 0) {
        $fileName = uniqid() . '.' . pathinfo($_FILES['image']['name'])['extension'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/' . $fileName);
        isset($_POST['isPublic']) ? $isPublic = true : $isPublic = false;
        addImageToDb($pdo, $fileName, $isPublic);
        header('Location: dashboard.php');
    }
}

?>

<h2>Publier une image : </h2>
<div class="container">
    <form method="post" action="addImage.php" enctype="multipart/form-data">
        <div class="form-group">
            <div class="form-group">
                <label for="image">Ajouter une image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="isPublic" name="isPublic">
                <label class="form-check-label" for="isPublic">Rendre publique</label>
            </div>

        </div>

        <input type="submit" placeholder="Publier"/>
        <?php
        displayErrors($errors);
        ?>
    </form>
</div>

<?php
require_once 'parts/footer.php';
