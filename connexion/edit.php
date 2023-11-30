<?php
require_once "db.php";
require_once "User.php";

// Create a user object
$user = new User($db);

// If not logged in, redirect to the login page
if (!$user->isLoggedIn()) {
    header("location: login.php");
}

// Get current user data
$currentUser = $user->getUser();

if (!isset($_GET['id'])) {
    die("Error");
}

// Get data
$query = $db->prepare("SELECT * FROM `tblogin` WHERE id = :id");
$query->bindParam(":id", $_GET['id']);
$query->execute();

if ($query->rowCount() == 0) {
    // No result
    die("Error: ID Not found");
} else {
    // ID found, get data
    $data = $query->fetch();
}

$errors = [];

if (isset($_POST['submit'])) {
    // Save input data to variables, convert HTML tags to prevent XSS
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);

    // Validate input
    if (empty($name)) {
        $errors[] = "Nom is required";
    }

    if (empty($email)) {
        $errors[] = "Adresse is required";
    }

    // If no errors, update data
    if (empty($errors)) {
        // Prepared statement to update data
        $query = $db->prepare("UPDATE `tblogin` SET `name`=:name, `email`=:email WHERE id=:id");
        $query->bindParam(":name", $name);
        $query->bindParam(":email", $email);
        $query->bindParam(":id", $_GET['id']);
        $query->execute();

        // Redirect to index.php
        header("location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        h1, h3 {
            color: #dc3545;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
        <h3>Welcome <span style="color: red;"><?php echo $currentUser['name'] ?></span>, <a href="logout.php">Logout</a></h3>
        <h1>Edit User Data</h1><br>

        <?php
        // Display errors, if any
        if (!empty($errors)) {
            echo '<div class="alert alert-danger">';
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo '</div>';
        }
        ?>

        <hr />

        <form method="post" id="userForm">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input required type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $data['name'] ?>" />
            </div>
            <div class="form-group">
                <label for="email">Adresse:</label>
                <input required type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $data['email'] ?>" />
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#userForm").validate();
        });
    </script>
</body>

</html>