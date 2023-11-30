<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
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
<br>
<br>
<br>

<br>
<br>
<br>
<header class="header">

<div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="view_products.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>
        
    </div>

    <div class="sidebar">
        <a href="#">
            <img src="../Sources/icons/facebook1.png" alt="facebook">
        </a>
        <a href="#">
            <img src="../Sources/icons/instagramm.png" alt="Instagram">
        </a>
        <a href="#">
            <img src="../Sources/icons/linkedin.png" alt="linkedin">
        </a>
        <a href="#">
            <img src="../Sources/icons/whatsapp.png" alt="whatsapp">
        </a>
    </div>
    <div class="logo">
        <img src="../Sources/LOGO.png" alt="Logo">
    </div>

<section class="flex">
   
      <nav class="navbar">
         <a href="orders.php">my orders</a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="shopping_cart.php" class="cart-btn">cart<span><?= $total_cart_items; ?></span></a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>
   </section>

   <section class="flex">
   
      <nav class="navbar">
         
         <a href="add_product.php">add product</a>
         <a href="view_products.php">view products</a>
         <a href="indexType.php">index products types table</a>
         <a href="indexProduct.php">index products table</a>
         
        
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>
   </section>
<header>