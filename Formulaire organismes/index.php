<?php
include '../ConnexionBD.php';

$notificationMessage = ''; // Initialisez la variable pour stocker le message de notification

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le type de formulaire
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    if ($type === 'association') {
        $Nom_Org = htmlspecialchars($_POST['nomAssociation']);
        $Description = htmlspecialchars($_POST['descriptionAssociation']);

        $stmt = $conn->prepare("INSERT INTO organisations (Nom_Org, Description) VALUES (:Nom_Org, :Description)");
        $stmt->bindParam(':Nom_Org', $Nom_Org);
        $stmt->bindParam(':Description', $Description);
        $stmt->execute();
        $lastInsertedId = $conn->lastInsertId(); // Récupérer l'ID nouvellement inséré
        $notificationMessage = 'Organisation ajoutée avec succès';
    } elseif ($type === 'societe') {
        $Nom_Soc = htmlspecialchars($_POST['nom']);
        $Desc_Soc = htmlspecialchars($_POST['description']);
        $matricule = htmlspecialchars($_POST['matricule']);

        $stmt = $conn->prepare("INSERT INTO société (Nom_Soc, Desc_Soc, matricule) VALUES (:Nom_Soc, :Desc_soc, :matricule)");
        $stmt->bindParam(':Nom_Soc', $Nom_Soc);
        $stmt->bindParam(':Desc_soc', $Desc_Soc);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        $lastInsertedId = $conn->lastInsertId(); // Récupérer l'ID nouvellement inséré
        $notificationMessage = 'Entreprise ajoutée avec succès!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organismes</title>
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

    <div class="form-container" id="association-container">
        <form action="" method="post" class="form">
            <h2>Je suis une association</h2>
            <label for="nomAssociation">Nom :</label>
            <input type="text" name="nomAssociation" id="nomAssociation" required>
            <label for="descriptionAssociation">Description :</label>
            <textarea name="descriptionAssociation" id="descriptionAssociation" rows="4" cols="50"></textarea>
            <input type="hidden" name="type" value="association">
            <input type="submit" value="Ajouter organisation">
            <div id="notification"></div>
        </form>
    </div>

    <div class="form-container" id="entreprise-container">
        <form action="" method="post" class="form">
            <h2>Je suis une société</h2>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
            <label for="matricule">Matricule fiscale :</label>
            <input type="text" name="matricule" id="matricule">
            <label for="description">Description :</label>
            <textarea name="description" id="description" rows="4" cols="50"></textarea>
            <input type="hidden" name="type" value="societe">
            <input type="submit" value="Ajouter entreprise">
        </form> 
    </div>
    <div id="notification-container" class="notification-container"></div>
    <script>
    function showNotification(message, entityId, entityType) {
        var notificationContainer = document.getElementById('notification-container');
        notificationContainer.innerHTML = message;
        notificationContainer.style.display = 'block';

        // Vérifier le type d'entité et construire le lien en conséquence
        var entityLink = '';
        if (entityType === 'association') {
            entityLink = 'profil.php?id=' + entityId;
        } else if (entityType === 'societe') {
            entityLink = 'profil_soc.php?id=' + entityId;
        }

        // Ajouter un lien vers la page profil avec l'ID
        var linkElement = document.createElement('a');
        linkElement.href = entityLink;
        linkElement.textContent = ' Consulter votre profil';
        notificationContainer.appendChild(linkElement);

        setTimeout(function() {
            notificationContainer.style.display = 'none';
        }, 5000); // La notification disparaîtra après 3 secondes
    }

    // Ajoutez ceci pour gérer la notification côté client
    var successMessage = "<?php echo $notificationMessage; ?>";
    var entityId = "<?php echo $lastInsertedId; ?>";
    var entityType = "<?php echo $type; ?>"; // Ajoutez ceci pour récupérer le type

    if (successMessage) {
        showNotification(successMessage, entityId, entityType);
    }
</script>

</body>
</html>