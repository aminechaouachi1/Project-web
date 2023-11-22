<?php
include '../ConnexionBD.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_id'])) {
    $org_id = $_POST['org_id'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM organisations WHERE ID_Organisation = :org_id");
    $stmt->bindParam(':org_id', $org_id);

    if ($stmt->execute()) {
        $_SESSION['delete_success'] = true;
        header('Location: index.php?message=organisation_deleted');
        exit();
    } else {
        $_SESSION['delete_success'] = false;
        header('Location: index.php?message=delete_error');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
