<?php
include 'connexiondb.php';

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create operation
    if (isset($_POST['create'])) {
        $titre = htmlspecialchars($_POST['actionTitle']);
        $description = htmlspecialchars($_POST['actionDescription']);

        $stmt = $conn->prepare("INSERT INTO annonces (titre, description) VALUES (:titre, :description)");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    // Update operation
    elseif (isset($_POST['update'])) {
        $id_comments = $_POST['id_comments']; // Update this line
        $titre = htmlspecialchars($_POST['actionTitle']);
        $description = htmlspecialchars($_POST['actionDescription']);

        $stmt = $conn->prepare("UPDATE annonces SET titre = :titre, description = :description WHERE id_annonces = :id_comments");
        $stmt->bindParam(':id_comments', $id_comments);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    // Delete operation
    elseif (isset($_POST['delete'])) {
        $id_comments = $_POST['id_comments']; // Update this line

        $stmt = $conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_comments");
        $stmt->bindParam(':id_comments', $id_comments);
        $stmt->execute();
    }

    // Redirect after CRUD operation
    header('Location: actions.php');
    exit();
}

// Read operation (from update also)
if (isset($_GET['edit'])) {
    $id_comments = $_GET['edit']; // Update this line

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_comments");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $editTitle = $row['titre'];
    $editDescription = $row['description'];
    $editId = $row['id_comments']; // Update this line
}

// Fetch all data for displaying
$stmt = $conn->prepare("SELECT * FROM annonces");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <!-- Add any additional stylesheets if needed -->
    <div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>

    </div>
</head>

<body>
    <div class="sidebar">
        <a href="#">
            <img src="../Sources/icons/facebook1.png" alt="facebook">
        </a>
        <a href="#">
            <img src="../Sources/icons/instagramm.png" alt="Instagram">
        </a>
        <a href="#">
            <img src="../Sources/icons/linkedin.png" alt="linkedin">
        </a>
        <a href="#">
            <img src="../Sources/icons/whatsapp.png" alt="whatsapp">
        </a>
    </div>
    <div class="rectanglecover">
        <h1>Actions en cours</h1>
    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

    <div class="center-container">
        <?php foreach ($rows as $row) : ?>
        <div class="rectangle">
            <div class="logo1">
                <img src="../Sources/crt.png" alt="Logo">
            </div>
            <div class="texte">
                <h3><?= $row['titre'] ?></h3>
                <p><?= $row['description'] ?></p>
            </div>
            <div class="rectangle_don">
                <a href="../connexion/connexion.php">Faire un don</a>
            </div>
            <div class="edit-delete-buttons">
                <a href="edit_announce.php?edit=<?= $row['id_annonces'] ?>" class="edit-button">Edit</a>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                    <input type="hidden" name="delete" value="1">
                    <input type="submit" value="Delete" class="delete-button" onclick="return confirm('Are you sure?')">
                </form>
                <a href="comments.php?id_comments=<?= $row['id_annonces'] ?>" class="comments-button">Comments</a>

            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <!-- Add your scripts here -->

    <div class="sidebarannonce">
        <a href="create_announce.php">Créer une annonce</a> <!-- Modify this line -->
    </div>
</body>

</html>