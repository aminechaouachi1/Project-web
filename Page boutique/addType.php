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
    $user_id = htmlentities($_COOKIE['user_id']);
}else{
    setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

if(isset($_POST['add'])){
    $new_name = $_POST['name'];
    $new_name = filter_var($new_name, FILTER_SANITIZE_STRING);

    // Insert the new type into the database
    $add_type = $conn->prepare("INSERT INTO `types` (name) VALUES (?)");
    $add_type->execute([$new_name]);

    // Redirect to indexType.php or any other appropriate page
    if (!$add_type) {
        // Handle error (e.g., display an error message)
        echo "Error: " . $conn->errorInfo()[2];
    } else {
        header('location: indexType.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add type</title>
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
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="add-type">

    <h1 class="heading">Add Product Type</h1>

    <div class="container">
        <form action="" method="POST" name="addTypeForm">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <input type="submit" name="add" value="Add">
        </form>
    </div>

</section>

<?php include 'components/alert.php'; ?>

</body>
</html>
