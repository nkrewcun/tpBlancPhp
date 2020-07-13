<?php
require_once 'parts/includes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}

$result = getPhotoById($pdo, $_GET['id']);
$res = $result->fetch();
if (!$res) {
    header('Location: index.php');
}

?>

    <div class="card mx-auto    " style="max-width: 40rem;">
        <img src="assets/images/<?php echo $res['file_name']; ?>" class="card-img-top"
             alt="<?php echo $res['file_name'] ?>">
        <div class="card-body">
            <p class="card-text"><strong>Publiée le
                    : </strong><?php echo date('d/m/Y', strtotime($res['date_publication'])) . ' à ' . date('H:i:s', strtotime($res['date_publication'])); ?>
            </p>
            <p class="card-text"><strong>À : </strong><?php echo $res['lieu_publi']; ?></p>
            <p class="card-text"><strong>Par : </strong><?php echo $res['nom_prenom_utilisateur']; ?></p>
            <?php
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']['pseudo'] === $res['nom_prenom_utilisateur']) {
                    echo '<a href="deleteImage.php?id=' . $res['id'] . '" class="btn btn-secondary">Supprimer</a>';
                }
            }
            ?>
        </div>
    </div>

<?php
$result->closeCursor();
require_once 'parts/footer.php';
