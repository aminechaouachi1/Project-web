<?php
include 'connexiondb.php';

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
        $id_annonces = $_POST['id_annonces']; // Updated from $_POST['id']
        $titre = htmlspecialchars($_POST['actionTitle']);
        $description = htmlspecialchars($_POST['actionDescription']);

        $stmt = $conn->prepare("UPDATE annonces SET titre = :titre, description = :description WHERE id_annonces = :id_annonces");
        $stmt->bindParam(':id_annonces', $id_annonces);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    // Delete operation
    elseif (isset($_POST['delete'])) {
        $id_annonces = $_POST['id_annonces'];

        $stmt = $conn->prepare("DELETE FROM annonces WHERE id_annonces = :id_annonces");
        $stmt->bindParam(':id_annonces', $id_annonces);
        $stmt->execute();
    }

    header('Location: process_action.php');
    exit();
}

//Read operation (from update also)
if (isset($_GET['edit'])) {
    $id_annonces = $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_annonces");
    $stmt->bindParam(':id_annonces', $id_annonces);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $editTitle = $row['titre'];
    $editDescription = $row['description'];
    $editId = $row['id_annonces'];
}

//Fetch all data for displaying
$stmt = $conn->prepare("SELECT * FROM annonces");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="actions.css">
    <title>Interface Centrée</title>
</head>

<body>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

    <div class="menu">
        <a href="#" class="menu-link">Home</a>
        <a href="#" class="menu-link">About</a>
        <a href="#" class="menu-link">Contact</a>
    </div>

    <div class="content-container">
        <div class="big-rectangle">
            <div class="text-container">
                <!-- Form for creating and updating -->
                <form action="" method="POST">
                    <?php if (isset($editId)) : ?>
                    <input type="hidden" name="id_annonces" value="<?= $editId ?>">
                    <input type="hidden" name="update" value="1">
                    <?php else : ?>
                    <input type="hidden" name="create" value="1">
                    <?php endif; ?>

                    <label for="actionTitle">Titre annonce :</label>
                    <input type="text" id="actionTitle" name="actionTitle"
                        value="<?= isset($editTitle) ? $editTitle : '' ?>" required />

                    <label for="actionDescription">Description annonce :</label>
                    <textarea id="actionDescription" name="actionDescription"
                        required><?= isset($editDescription) ? $editDescription : '' ?></textarea>

                    <input type="submit" value="<?= isset($editId) ? 'Update' : 'Add Action' ?>"
                        class="validate-button" />
                </form>

                <!-- Display existing data with options to edit and delete -->
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
                                <a href="?edit=<?= $row['id_annonces'] ?>">Edit</a>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                                    <input type="hidden" name="delete" value="1">
                                    <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="actions.js"></script>
</body>

</html>