<?php
include '../ConnexionBD.php';

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données associées à l'ID depuis la base de données
    $stmt = $conn->prepare("SELECT * FROM organisations WHERE ID_Organisation = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si des données ont été trouvées
    if ($result) {
        $nomOrg = $result['Nom_Org'];
        $descriptionOrg = $result['Description'];
        // ... récupérez d'autres données si nécessaire ...
    } else {
        // Gérer le cas où aucune donnée n'est trouvée pour l'ID donné
        echo "Aucune organisation trouvée pour l'ID donné.";
        exit();
    }
} else {
    // Gérer le cas où l'ID n'est pas passé dans l'URL
    echo "ID non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organismes</title>
    <link rel="stylesheet" href="profil.css">
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
<!-- Affichez les données récupérées ici -->
<h1>Profil de l'Organisation</h1>
<p><strong>Nom :</strong> <?php echo $nomOrg; ?></p>
<p><strong>Description :</strong> <?php echo $descriptionOrg; ?></p>
<div class="actions">
<button id="editBtn" data-org-id="<?php echo $id; ?>">Modifier</button>
<button id="deleteBtn" data-org-id="<?php echo $id; ?>">Supprimer</button>
</div>


<!-- Votre script JavaScript -->
<script>
    document.getElementById('editBtn').addEventListener('click', function() {
        // Récupérer l'ID de l'organisation à modifier
        var organizationId = this.getAttribute('data-org-id');

        // Rediriger vers la page de modification avec l'ID en paramètre
        window.location.href = 'edit_organization.php?id=' + organizationId;
    });

    document.getElementById('deleteBtn').addEventListener('click', function() {
        // Récupérer l'ID de l'organisation à supprimer
        var organizationId = this.getAttribute('data-org-id');

        // Demander confirmation avant de supprimer
        var confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cette organisation ?");
        if (confirmDelete) {
            // Rediriger vers la page de suppression avec l'ID en paramètre
            window.location.href = 'delete_organization.php?id=' + organizationId;
        }
    });
</script>  
<style>
    .actions {
    text-align: center;
    margin-top: 20px;
    display: flex; /* Utiliser Flexbox pour centrer les boutons */
    justify-content: center;
}

.actions button {
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    margin: 0 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.actions button:hover {
    background-color: #45a049;
}

/* Style spécifique pour le bouton "Supprimer" */
.actions #deleteBtn {
    background-color: #f44336;
}

.actions #deleteBtn:hover {
    background-color: #d32f2f;
}
</style> 
</body>
</html>
