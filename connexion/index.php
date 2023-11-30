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

// Fetch all data from tblogin
$query = $db->prepare("SELECT * FROM tblogin");
$query->execute();
$data = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">
    <style>
        /* Additional CSS styles for table customization */
        table {
            font-size: 18px;
            margin-top: 20px;
            width: 90%; /* Adjust the width as needed */
            max-width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            padding: 20px;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
    <h3>Welcome <span style="color: red;"><?php echo $currentUser['name'] ?></span>, <a href="logout.php">Logout</a></h3>
        <h1>Liste des users</h1>
        <br>
        <hr /><br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>#ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <!-- Loop to display data -->
                <?php foreach ($data as $value): ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $value['id'] ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['email'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Sure to delete data!');">Delete</a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
