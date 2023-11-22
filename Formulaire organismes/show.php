<?php
include '../ConnexionBD.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Response</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <h1>Form Response</h1>

        <?php
        if (isset($_GET['message']) && $_GET['message'] === 'organisation_added') {
            echo '<p class="success-message">Organisation added successfully!</p>';
            
            if (isset($_SESSION['submitted_data'])) {
                echo '<h2>Submitted Data:</h2>';
                echo '<p><strong>Nom_Org:</strong> ' . $_SESSION['submitted_data']['Nom_Org'] . '</p>';
                echo '<p><strong>Description:</strong> ' . $_SESSION['submitted_data']['Description'] . '</p>';
            }

            unset($_SESSION['submitted_data']);
        }
        ?>

        <p><a href="index.php" class="back-link">Back to Form</a></p>
    </div>
</body>
</html>
