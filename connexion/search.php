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

// Handle the search query
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $query = "SElECT * FROM tblogin WHERE name LIKE :q OR email LIKE :q";
    $q = "%" . $q . "%";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':q', $q);
    $stmt->execute();
    $jml = $stmt->rowCount();

    if ($jml > 0) {
        echo "<table class='table table-bordered mt-4'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>";

        $no = 1;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>
                    <td>$no</td>
                    <td>{$id}</td>
                    <td>{$name}</td>
                    <td>{$email}</td>
                </tr>";
            $no++;
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='mt-4'>Result <b>{$_GET['q']}</b> not found</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">
</head>

<body class="container mt-5">
    <?php include 'components/header.php'; ?>
    <h3>Welcome <span style="color: red;"><?php echo $currentUser['name'] ?></span>, <a href="logout.php">Logout</a></h3>
    <br>
    <h1>Search</h1>
    <hr>

    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4" id="userForm">
        <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Enter a name" value="<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>" />
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
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
