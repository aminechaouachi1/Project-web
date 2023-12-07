<?php
session_start();
include 'connexiondb.php';

// Initialize an empty error message
$commentError = '';

// Initialize $viewTitle, $viewDescription, and $viewId variables
$viewTitle = $viewDescription = $viewId = '';

// Check if the form is submitted to add a new comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComment'])) {
    $id_annonces = isset($_POST['id_annonces']) ? $_POST['id_annonces'] : null;
    $desc_comment = htmlspecialchars($_POST['desc_comment']);

    if (!empty($desc_comment)) {
        try {
            // Save the new comment to the database
            $stmt = $conn->prepare("INSERT INTO comments (desc_comment, id_annonces) VALUES (:desc_comment, :id_annonces)");
            $stmt->bindParam(':desc_comment', $desc_comment);
            $stmt->bindParam(':id_annonces', $id_annonces);
            $stmt->execute();

            // Optionally, you can redirect the user after adding a comment
            header("Location: comments.php?id_annonces=$id_annonces");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $commentError = "Please enter a non-empty comment.";
    }
} elseif (isset($_GET['id_annonces'])) {
    $id_comments = $_GET['id_annonces'];

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_comments");
    $stmt->bindParam(':id_comments', $id_comments);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $viewTitle = $row['titre'];
    $viewDescription = $row['description'];
    $viewId = $row['id_annonces'];
}

// Check if the id_annonces is set in the URL
if (isset($_GET['id_annonces'])) {
    $id_annonces = $_GET['id_annonces'];

    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonces = :id_annonces");
    $stmt->bindParam(':id_annonces', $id_annonces);
    $stmt->execute();
    $announcement = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch comments for the selected announcement from the database
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_annonces = :id_annonces");
    $stmt->bindParam(':id_annonces', $id_annonces);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If id_annonces is not set, redirect to actions.php
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

    <style>
    .voting-stars {
        margin-top: 0px;
        /* Adjusted margin-top for spacing */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .voting-stars form {
        display: flex;
        align-items: center;
        margin-left: 500px;
        /* Adjusted margin-left to add space to the left */

    }

    .center-container {
        text-align: center;
    }

    .rectangle {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 10px;
        /* Adjusted margin to reduce space */
    }

    .rectangle .logo1 {
        display: flex;
        justify-content: center;
        /* Center the image horizontally */
        margin-bottom: 10px;
    }

    /* Add the logo size style */
    .logo1 img {
        max-width: 100px;
        /* Adjust the value to your desired maximum width */
        height: auto;
        /* Ensures the image scales proportionally */
    }

    .texte {
        margin-top: 10px;
    }

    .texte1 {
        margin-top: 10px;
    }

    .comments-section {
        margin-top: 0px;
    }

    .comment-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 0px;
    }

    .comment-id {
        font-weight: bold;
        color: #333;
    }

    .comment-text {
        margin-top: 5px;
        color: #555;
    }


    .comments-container {
        margin-top: 10px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        text-align: center;
        /* Center text and button */
        max-width: 600px;
        /* Adjusted max-width to make it smaller horizontally */
        margin-left: auto;
        margin-right: auto;
    }

    .comment-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        max-width: 100%;
        /* Adjusted max-width to make it smaller horizontally */
        box-sizing: border-box;
    }

    #desc_comment {
        width: 100%;
        padding: 8px;
        margin-top: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f4f4f4;
        /* Change the background color of the text area */
    }

    .comment-button {
        background-color: #4CAF50;
        /* Change the background color of the button */
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    </style>
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
        <div class="rectangle">
            <div class="logo1">
                <img src="../Sources/crt.png" alt="Logo">
            </div>
            <div class="voting-stars">
                <form action="comments.php" method="post">
                    <input type="hidden" name="announce_id" value="<?= $viewId ?>">
                    <label for="star1">1 Star</label>
                    <input type="radio" id="star1" name="vote" value="1">

                    <label for="star2">2 Stars</label>
                    <input type="radio" id="star2" name="vote" value="2">

                    <label for="star3">3 Stars</label>
                    <input type="radio" id="star3" name="vote" value="3">

                    <label for="star4">4 Stars</label>
                    <input type="radio" id="star4" name="vote" value="4">

                    <label for="star5">5 Stars</label>
                    <input type="radio" id="star5" name="vote" value="5">

                    <input type="submit" value="Vote">
                </form>
            </div>

            <div class="texte">
                <h3><?= $viewTitle ?></h3>
            </div>
            <div class="texte1">
                <p><?= $viewDescription ?></p>
            </div>
        </div>
    </div>

    <div class="comments-container">
        <h4>Comments</h4>
        <?php foreach ($comments as $comment) : ?>
        <div class="comment-box">
            <p class="comment-id">Comment ID: <?= $comment['id_comments'] ?></p>
            <p class="comment-text"><?= $comment['desc_comment'] ?></p>
        </div>
        <?php endforeach; ?>

        <!-- Add a form to submit new comments with client-side validation -->
        <form action="" method="post" id="commentForm" onsubmit="addComment(event);">
            <input type="hidden" name="id_annonces" value="<?= $id_annonces ?>">
            <label for="desc_comment">Add a comment:</label>
            <textarea name="desc_comment" id="desc_comment" rows="4" cols="50"></textarea>
            <div id="commentError"><?php echo $commentError; ?></div>
            <button type="submit" name="addComment" class="comment-button">Add Comment</button>
        </form>
    </div>
    <!-- Updated JavaScript code in the <head> section of your HTML -->
    <script>
    function addComment(event) {
        event.preventDefault(); // Prevent the default form submission

        var commentInput = document.getElementById('desc_comment');
        var commentError = document.getElementById('commentError');

        // Check if the comment is empty
        if (commentInput.value.trim() === "") {
            commentError.textContent = "Please enter a non-empty comment.";
            return;
        }

        // Clear the error message if the comment is not empty
        commentError.textContent = "";


        // Create a new comment box
        var newCommentBox = document.createElement("div");
        newCommentBox.className = "comment-box";

        // Create a paragraph for the comment ID
        var commentIdParagraph = document.createElement("p");
        commentIdParagraph.className = "comment-id";
        commentIdParagraph.textContent = "Comment ID: New";

        // Create a paragraph for the comment text
        var commentTextParagraph = document.createElement("p");
        commentTextParagraph.className = "comment-text";
        commentTextParagraph.textContent = commentInput.value;

        // Append paragraphs to the comment box
        newCommentBox.appendChild(commentIdParagraph);
        newCommentBox.appendChild(commentTextParagraph);

        // Append the new comment box to the comments section
        var commentsSection = document.querySelector(".comments-section");
        commentsSection.appendChild(newCommentBox);

        // Optionally, clear the textarea or do any other necessary actions
        commentInput.value = '';
    }


    function validateComment() {
        var commentInput = document.getElementById('desc_comment');
        var commentError = document.getElementById('commentError');

        // Check if the comment is empty
        if (commentInput.value.trim() === "") {
            commentError.textContent = "Please enter a non-empty comment.";
            return false;
        }

        // Clear the error message if the comment is not empty
        commentError.textContent = "";

        // Add any additional validation logic here if needed

        return true;
    }
    </script>

</body>

</html>