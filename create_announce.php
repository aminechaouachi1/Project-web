<!-- create_announce.php -->

<?php
include 'connexiondb.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $titre = htmlspecialchars($_POST['actionTitle']);
    $description = htmlspecialchars($_POST['actionDescription']);

    // Insert new announcement into the database
    $stmt = $conn->prepare("INSERT INTO annonces (titre, description) VALUES (:titre, :description)");
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->execute();

    // Redirect to actions.php after creating the announcement
    header('Location: actions.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announce</title>
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

    .create-container {
        width: 80%;
        max-width: 800px;
        background-color: #fff;
        border: 2px solid #ccc;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }

    .create-container label {
        display: block;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .create-container input,
    .create-container textarea {
        width: 100%;
        padding: 15px;
        margin-bottom: 30px;
        box-sizing: border-box;
        font-size: 20px;
        resize: none;
        /* Disable textarea resizing */
    }

    .create-container button {
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
        <div class="create-container">
            <!-- Form for creating a new announcement -->
            <form action="" method="POST">
                <input type="hidden" name="create" value="1">

                <label for="actionTitle">Titre annonce :</label>
                <input type="text" id="actionTitle" name="actionTitle" />

                <label for="actionDescription">Description annonce :</label>
                <textarea id="actionDescription" name="actionDescription"></textarea>

                <button type="submit">Create</button>
            </form>
        </div>
    </div>

    <!-- Add your scripts here -->
</body>

</html>