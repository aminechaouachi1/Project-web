<!-- edit_announce.php -->

<?php
include 'connexiondb.php';

// Check if an ID is provided in the URL
if (isset($_GET['edit'])) {
    $id_annonces = $_GET['edit'];

    // Fetch the announcement data
    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_annonces");
    $stmt->bindParam(':id_annonces', $id_annonces);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $editTitle = $row['titre'];
    $editDescription = $row['description'];
    $editId = $row['id_annonces'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $newTitle = htmlspecialchars($_POST['actionTitle']);
        $newDescription = htmlspecialchars($_POST['actionDescription']);

        // Update the database
        $updateStmt = $conn->prepare("UPDATE annonces SET titre = :titre, description = :description WHERE id_annonces = :id_annonces");
        $updateStmt->bindParam(':id_annonces', $id_annonces);
        $updateStmt->bindParam(':titre', $newTitle);
        $updateStmt->bindParam(':description', $newDescription);
        $updateStmt->execute();

        // Redirect to actions.php after the update
        header('Location: actions.php');
        exit();
    }
} else {
    // If no ID is provided, redirect to the main page
    header('Location: actions.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announce</title>
    <!-- Add any additional stylesheets if needed -->
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .edit-container {
        width: 80%;
        max-width: 800px;
        background-color: #fff;
        border: 2px solid #ccc;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }

    .edit-container label {
        display: block;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .edit-container input,
    .edit-container textarea {
        width: 100%;
        padding: 15px;
        margin-bottom: 30px;
        box-sizing: border-box;
        font-size: 20px;
        resize: none;
        /* Disable textarea resizing */
    }

    /* Make the textarea larger */
    .edit-container textarea {
        height: 200px;
    }

    .edit-container button {
        background-color: #4CAF50;
        color: white;
        padding: 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-size: 24px;
    }
    </style>
</head>

<body>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

    <div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>
    </div>

    <div class="content-container">
        <div class="edit-container">
            <!-- Form for updating title and description -->
            <form action="" method="POST">
                <input type="hidden" name="id_annonces" value="<?= $editId ?>">
                <input type="hidden" name="update" value="1">

                <label for="actionTitle">Titre annonce :</label>
                <input type="text" id="actionTitle" name="actionTitle" value="<?= $editTitle ?>" required />

                <label for="actionDescription">Description annonce :</label>
                <textarea id="actionDescription" name="actionDescription" required><?= $editDescription ?></textarea>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <!-- Add your scripts here -->
</body>

</html>