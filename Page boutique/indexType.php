<?php
include 'components/connect.php';
function create_unique_id(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
 }
 
 if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
 }
// Fetch types from the database
$types_query = $conn->query("SELECT * FROM `types`");
$types = $types_query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Types</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Additional stylesheets if needed -->
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="types">

    <h1 class="heading">Product Types</h1>
    <a href="addType.php" class="btn btn-primary">Add Type</a>
    <div class="container">
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../Page boutique/Boutique.css">
   <link rel="stylesheet" href="css/style.css">

   <link rel="stylesheet" href="css/style.css">

        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?= $type['id']; ?></td>
                        <td><?= $type['name']; ?></td>
                        <td>
                  <a href="editType.php?id=<?= $type['id']; ?>" class="btn btn-primary">Edit</a>
                  <a href="deleteType.php?id=<?= $type['id']; ?>" class="btn btn-danger">Delete</a>
               </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>

<?php include 'components/alert.php'; ?>

</body>
</html>
