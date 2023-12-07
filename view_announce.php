<!-- view_announce.php -->

<?php
include 'connexiondb.php';

if (isset($_GET['id'])) {
    $id_comments = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_comments");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $viewTitle = $row['titre'];
    $viewDescription = $row['description'];
    $viewId = $row['id_annonces'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $viewTitle ?> - View Announce</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <!-- Add any additional stylesheets if needed -->
    <div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>

    </div>
    <style>
    .voting-stars {
        margin-top: 10px;
        text-align: center;
    }

    .voting-stars form {
        display: inline-block;
    }

    .center-container {
        text-align: center;
    }

    .rectangle {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 20px;
    }

    .rectangle .logo1 {
        display: flex;
        justify-content: center;
        /* Center the image horizontally */
        margin-bottom: 10px;
    }

    /* Add the logo size style */
    .logo1 img {
        max-width: 100px;
        /* Adjust the value to your desired maximum width */
        height: auto;
        /* Ensures the image scales proportionally */
    }

    .texte {
        margin-top: 10px;
    }

    .texte1 {
        margin-top: 10px;
    }
    </style>
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
        <div class="rectangle">
            <div class="logo1">
                <img src="../Sources/crt.png" alt="Logo">
            </div>
            <div class="voting-stars">
                <form action="actions.php" method="post">
                    <input type="hidden" name="announce_id" value="<?= $viewId ?>">
                    <label for="star1">1 Star</label>
                    <input type="radio" id="star1" name="vote" value="1">

                    <label for="star2">2 Stars</label>
                    <input type="radio" id="star2" name="vote" value="2">

                    <label for="star3">3 Stars</label>
                    <input type="radio" id="star3" name="vote" value="3">

                    <label for="star4">4 Stars</label>
                    <input type="radio" id="star4" name="vote" value="4">

                    <label for="star5">5 Stars</label>
                    <input type="radio" id="star5" name="vote" value="5">

                    <input type="submit" value="Vote">
                </form>
            </div>

            <div class="texte">
                <h3><?= $viewTitle ?></h3>
            </div>
            <div class="texte1">
                <p><?= $viewDescription ?></p>
            </div>
        </div>
    </div>


    <!-- ... (Your existing HTML code) -->

    <div class="sidebarannonce">
        <a href="create_announce.php">Créer une annonce</a>
    </div>
</body>

</html>