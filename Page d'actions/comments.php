<?php
include 'connexiondb.php';

// Initialize an empty error message
$commentError = '';

// Check if the form is submitted to add a new comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComment'])) {
    $announcement_id = isset($_POST['id_comments']) ? $_POST['id_comments'] : null;
    $desc_comment = htmlspecialchars($_POST['desc_comment']);

    if (!empty($desc_comment)) {
        try {
            $stmt = $conn->prepare("INSERT INTO comments (id_comments, desc_comment) VALUES (:id_comments, :desc_comment)");
            $stmt->bindParam(':id_comments', $announcement_id);
            $stmt->bindParam(':desc_comment', $desc_comment);
            $stmt->execute();

            // Fetch the newly added comment
            $newCommentStmt = $conn->prepare("SELECT * FROM comments WHERE id_comments = :id_comments ORDER BY id_comments DESC LIMIT 1");
            $newCommentStmt->bindParam(':id_comments', $announcement_id);
            $newCommentStmt->execute();
            $newComment = $newCommentStmt->fetch(PDO::FETCH_ASSOC);

            // Send the new comment data to JavaScript for dynamic update
            echo '<script>';
            echo 'var newComment = ' . json_encode($newComment) . ';';
            echo 'var commentsSection = document.querySelector(".comments-section");';
            echo 'var newCommentElement = document.createElement("p");';
            echo 'newCommentElement.textContent = newComment.desc_comment;';
            echo 'commentsSection.appendChild(newCommentElement);';
            echo '</script>';
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $commentError = "Please enter a non-empty comment.";
    }
}

// Check if the id_comments is set in the URL
if (isset($_GET['id_comments'])) {
    $id_comments = $_GET['id_comments'];

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_comments");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();
    $announcement = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch comments for the selected announcement (including the latest one)
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_comments = :id_comments ORDER BY id_comments DESC");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If id_comments is not set, redirect to actions.php
    header('Location: actions.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <!-- Add your stylesheets here -->
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
</head>

<body>
    <!-- Add your menu and navigation bar here -->
    <div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>
    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>
    <div class="center-container">
        <!-- Display the selected announcement -->
        <div class="rectangle">
            <h3><?= $announcement['titre'] ?></h3>
            <p><?= $announcement['description'] ?></p>
        </div>

        <!-- Display existing comments -->
        <div class="comments-section">
            <h4>Comments</h4>
            <?php foreach ($comments as $comment) : ?>
            <p><?= $comment['desc_comment'] ?></p>
            <?php endforeach; ?>
        </div>

        <!-- Add a form to submit new comments with client-side validation -->
        <form action="" method="post" id="commentForm">
            <input type="hidden" name="id_comments" value="<?= $announcement_id ?>">
            <label for="desc_comment">Add a comment:</label>
            <textarea name="desc_comment" id="desc_comment" required></textarea>
            <div id="commentError" style="color: red;"><?php echo $commentError; ?></div>
            <button type="submit" name="addComment" onclick="return validateComment()">Comment</button>
        </form>
    </div>

    <!-- Add JavaScript to dynamically update the comments section and perform validation -->
    <script>
    function validateComment() {
        var commentInput = document.getElementById('desc_comment');
        var commentError = document.getElementById('commentError');

        if (commentInput.value.trim() === "") {
            commentError.textContent = "Please enter a non-empty comment.";
            return false;
        }

        // Optionally, clear the error message if the comment is not empty
        commentError.textContent = "";

        // Use AJAX or fetch to submit the form data asynchronously
        // Update the comments section with the new comment data
        var newCommentElement = document.createElement("p");
        newCommentElement.textContent = commentInput.value;
        document.querySelector(".comments-section").appendChild(newCommentElement);

        // Optionally, clear the textarea or do any other necessary actions
        commentInput.value = '';

        return true;
    }

    document.getElementById('commentForm').addEventListener('submit', function(event) {
        if (!validateComment()) {
            event.preventDefault(); // Prevent the default form submission if validation fails
        }
    });
    </script>

</body>

</html>