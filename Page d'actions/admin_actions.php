<!-- admin_actions.php -->

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "annonces";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete operation
    if (isset($_POST['delete'])) {
        $id_annonces = $_POST['id_annonces'];

        $stmt = $conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_annonces");
        $stmt->bindParam(':id_annonces', $id_annonces);
        $stmt->execute();

        // Redirect after CRUD operation
        header('Location: admin_actions.php');
        exit();
    }
} else {
    // Fetch all data for displaying
    $stmt = $conn->prepare("SELECT * FROM annonces");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin actions</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <!-- Add any additional stylesheets if needed -->
    <style>
    .logo {
        padding: 5px;
    }

    .menu {
        background-color: #dedede#;
        overflow: hidden;
    }

    .menu a {
        float: left;
        display: block;
        color: #000000;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .menu a:hover {
        background-color: #d7b20b;
        color: black;
    }

    .center-container {
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #d7b20b;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #ffffff;
    }

    .delete-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
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

    <div class="center-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['id_annonces'] ?></td>
                    <td><?= $row['titre'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                            <input type="hidden" name="delete" value="1">
                            <input type="submit" value="Delete" class="delete-button"
                                onclick="return confirm('Are you sure?')">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>