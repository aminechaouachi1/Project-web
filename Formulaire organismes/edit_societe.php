<?php
include '../ConnexionBD.php';

// Récupérer l'ID à partir de l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    // Gérer le cas où l'ID n'est pas spécifié
    echo "ID non spécifié.";
    exit();
}

// Récupérer les données de la société depuis la base de données
$stmt = $conn->prepare("SELECT * FROM société WHERE ID_Soc = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$societeData = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si des données ont été trouvées
if (!$societeData) {
    echo "Aucune société trouvée pour l'ID donné.";
    exit();
}

// Traitement des données du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newNomSoc = htmlspecialchars($_POST['nom']);
    $newMatricule = htmlspecialchars($_POST['matricule']);
    $newDescriptionSoc = htmlspecialchars($_POST['description']);

    // Mettez à jour les données dans la base de données
    $updateStmt = $conn->prepare("UPDATE société SET Nom_Soc = :newNomSoc, Desc_Soc = :newDescriptionSoc, matricule = :newMatricule WHERE ID_Soc = :id");
    $updateStmt->bindParam(':newNomSoc', $newNomSoc);
    $updateStmt->bindParam(':newMatricule', $newMatricule);
    $updateStmt->bindParam(':newDescriptionSoc', $newDescriptionSoc);
    $updateStmt->bindParam(':id', $id);

    if ($updateStmt->execute()) {
        // Rediriger vers la page du profil après la modification
        header("Location: profil_soc.php?id={$id}");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la société.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Société</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">
</head>
<body>

<div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>
    </div>
    <div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>
    <div class="container">
        <h1>Modifier la Société</h1>

        <form action="edit_societe.php?id=<?php echo $id; ?>" method="post" class="form">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo $societeData['Nom_Soc']; ?>" required>
            <label for="matricule">Matricule :</label>
            <input type="text" name="matricule" id="matricule" value="<?php echo $societeData['matricule']; ?>" required>
            <label for="description">Description :</label>
            <textarea name="description" id="description" rows="4" cols="50" required><?php echo $societeData['Desc_Soc']; ?></textarea>

            <input type="submit" value="Enregistrer les modifications">
        </form>
    </div>
</body>
</html>
<style>
    /* Ajoutez ici vos styles spécifiques si nécessaire */
</style>
