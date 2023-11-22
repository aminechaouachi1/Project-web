<?php
include 'ConnexionBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_organization'])) {
        $ID_OrganisationToDelete = $_POST['delete_organization'];

        $stmt = $conn->prepare("DELETE FROM organisations WHERE ID_Organisation = :ID_Organisation");
        $stmt->bindParam(':ID_Organisation', $ID_OrganisationToDelete);

        if ($stmt->execute()) {
            
        } else {
            echo "Error deleting organization.";
        }
    }

    if (isset($_POST['delete_societe'])) {
        $ID_SocieteToDelete = $_POST['delete_societe'];

        $stmt = $conn->prepare("DELETE FROM société WHERE ID_Soc = :ID_Soc");
        $stmt->bindParam(':ID_Soc', $ID_SocieteToDelete);

        if ($stmt->execute()) {
            
        } else {
            echo "Error deleting entreprise.";
        }
    }
}

$stmtOrganisations = $conn->prepare("SELECT * FROM organisations");
$stmtOrganisations->execute();
$rowsOrganisations = $stmtOrganisations->fetchAll(PDO::FETCH_ASSOC);

$stmtSociete = $conn->prepare("SELECT * FROM société");
$stmtSociete->execute();
$rowsSociete = $stmtSociete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Association</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rowsOrganisations as $row) : ?>
                <tr>
                    <td><?= $row['Nom_Org'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_organization" value="<?= $row['ID_Organisation'] ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <h1>Sociétés</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Matricule</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rowsSociete as $row) : ?>
                <tr>
                    <td><?= $row['Nom_Soc'] ?></td>
                    <td><?= $row['Desc_Soc'] ?></td>
                    <td><?= $row['matricule'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_societe" value="<?= $row['ID_Soc'] ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
