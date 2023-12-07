<?php
include 'connexiondb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_comments'])) {
    $id_comments = $_POST['id_comments'];

    // Fetch comments for the selected announcement (including the latest one)
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_comments = :id_comments ORDER BY id_comments DESC");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the comments data as JSON response
    header('Content-Type: application/json');
    echo json_encode($comments);
    exit();
}
?>