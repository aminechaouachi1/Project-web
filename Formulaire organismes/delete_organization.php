<?php
include '../ConnexionBD.php';

// Récupérer l'ID à partir de l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    // Gérer le cas où l'ID n'est pas spécifié
    echo "ID non spécifié.";
    exit();
}

// Supprimer l'organisation de la base de données
$stmt = $conn->prepare("DELETE FROM organisations WHERE ID_Organisation = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    // Rediriger vers la page d'accueil après la suppression
    header("Location: ../Page d'accueil/accueil.php");
    exit();
} else {
    echo "Erreur lors de la suppression de l'organisation.";
}
?>
