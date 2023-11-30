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
 if(isset($_GET['id'])){
    $type_id = $_GET['id'];

    // Fetch the type from the database based on the provided type_id
    $select_type = $conn->prepare("SELECT * FROM `types` WHERE id = ?");
    $select_type->execute([$type_id]);
    
    // Check if the type with the specified type_id exists
    if($select_type->rowCount() > 0){
        $type = $select_type->fetch(PDO::FETCH_ASSOC);

        // If the 'update' form is submitted
        if(isset($_POST['update'])){
            $new_name = $_POST['new_name'];
            $new_name = filter_var($new_name, FILTER_SANITIZE_STRING);

            // Update the type in the database
            $update_type = $conn->prepare("UPDATE `types` SET name = ? WHERE id = ?");
            $update_type->execute([$new_name, $type_id]);

            // Redirect to indexType.php or any other appropriate page
            header('location: indexType.php');
        }
    } else {
        // Handle the case where the type with the specified type_id doesn't exist
        echo "Type not found!";
    }
} else {
    // Handle the case where the 'id' parameter is not set in the URL
    echo "Type ID is missing in the URL!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit type</title>
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

<section class="edit-type">

    <h1 class="heading">Edit Product Type</h1>

    <div class="container">
        <form action="" method="POST">
            <label for="new_name">New Name:</label>
            <input type="text" name="new_name" value="<?= $type['name']; ?>" required>
            <input type="submit" name="update" value="Update">
        </form>
    </div>

</section>

<?php include 'components/alert.php'; ?>

</body>
</html>