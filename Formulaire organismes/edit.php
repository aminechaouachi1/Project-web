<?php
include '../ConnexionBD.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['org_id'])) {
    $org_id = $_GET['org_id'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM organisations WHERE ID_Organisation = :org_id");
    $stmt->bindParam(':org_id', $org_id);
    $stmt->execute();

    // Fetch the data
    $org_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($org_data) {
        // Display the form with the fetched data for editing
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organisation</title>
    <link rel="stylesheet" href="style.css">
    <!-- Add your other stylesheets if needed -->
</head>
<body>
    <div class="container">
        <h1>Edit Organisation</h1>

        <form action="update.php" method="post">
            <input type="hidden" name="org_id" value="<?php echo $org_data['ID_Organisation']; ?>">

            <!-- Add your form fields and populate them with existing data -->
            <label for="nomAssociation">Nom :</label>
            <input type="text" name="nomAssociation" id="nomAssociation" value="<?php echo $org_data['Nom_Org']; ?>" required>
            <label for="descriptionAssociation">Description :</label>
            <textarea name="descriptionAssociation" id="descriptionAssociation" rows="4" cols="50" required><?php echo $org_data['Description']; ?></textarea>

            <input type="submit" value="Update Organisation">
        </form>

        <p><a href="index.php" class="back-link">Back to Form</a></p>
    </div>
    <!-- Include your scripts at the end of the body if needed -->
</body>
</html>
<?php
    } else {
        // Redirect to the index page if the organization is not found
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
