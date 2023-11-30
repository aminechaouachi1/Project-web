<?php
require_once "db.php";
require_once "User.php";

// Create user object
$user = new User($db);

// If not logged in, redirect to the login page
if (!$user->isLoggedIn()) {
    header("location: login.php");
}

// Get current user data
$currentUser = $user->getUser();

// Process form submission
if (isset($_POST['submit'])) {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    $query = $db->prepare("INSERT INTO `tblogin`(`name`, `email`, `password`) VALUES (:name, :email, :password)");
    $query->bindParam(":name", $name);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);

    $query->execute();

    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login/signup</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">
</head>

<body class="container mt-5">
    <?php include 'components/header.php'; ?>

    <h3>Welcome <span style="color: red;"><?php echo $currentUser['name'] ?></span>, <a href="logout.php">Logout</a></h3>
    <hr>
    <h1>Ajouter User</h1>
    <hr>

    <form method="post" class="mt-4" id="userForm">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input required type="text" class="form-control" name="name" placeholder="Nom">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input required type="text" class="form-control" name="email" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input required type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#userForm").validate();
        });
    </script>
</body>

</html>
