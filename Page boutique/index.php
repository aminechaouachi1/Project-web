<?php
session_start();
include_once("config.php");


//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shopping Cart</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../Page boutique/Boutique.css">
</head>
<body>
<div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
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
	<br>
	<br>
	<br>
	<br>
	<br>

<!-- View Cart Box Start -->
<?php
if (isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"]) > 0) {
    echo '<div class="cart-view-table-front" id="view-cart">';
    echo '<h3>Your Shopping Cart</h3>';
    echo '<form method="post" action="cart_update.php">';
    echo '<table width="100%"  cellpadding="6" cellspacing="0">';
    echo '<tbody>';

    $total = 0;
    $b = 0;

    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($_SESSION["cart_products"] as $cart_itm) {
            $product_code = $cart_itm["product_code"];
            $stmt = $pdo->prepare("SELECT * FROM products WHERE product_code=? LIMIT 1");
            $stmt->bindParam(1, $product_code);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $product_name = $product["product_name"];
                $product_qty = $cart_itm["product_qty"];
                $product_price = $product["price"];
              

                $bg_color = ($b++ % 2 == 1) ? 'odd' : 'even'; // Zebra stripe
                echo '<tr class="' . $bg_color . '">';
                echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty[' . $product_code . ']" value="' . $product_qty . '" /></td>';
                echo '<td>' . $product_name . '</td>';
                echo '<td><input type="checkbox" name="remove_code[]" value="' . $product_code . '" /> Remove</td>';
                echo '</tr>';

                $subtotal = ($product_price * $product_qty);
                $total += $subtotal;
            }
        }

        echo '<td colspan="4">';
        echo '<button type="submit">Update</button><a href="view_cart.php" class="button">Checkout</a>';
        echo '</td>';
        echo '</tbody>';
        echo '</table>';

        $current_url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        echo '<input type="hidden" name="return_url" value="' . $current_url . '" />';
        echo '</form>';
        echo '</div>';
    } catch (PDOException $e) {
        die('Error : ' . $e->getMessage());
    }
}
?>

<!-- View Cart Box End -->


<!-- Products List Start -->
<?php
try {
    $stmt = $pdo->query("SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");

    if ($stmt) {
        $products_item = '<ul class="products">';
        while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
            $products_item .= <<<EOT
            <li class="product">
                <form method="post" action="cart_update.php">
                    <div class="product-content">
                        <h3>{$obj->product_name}</h3>
                        <div class="product-thumb"><img src="images/{$obj->product_img_name}"></div>
                        <div class="product-desc">{$obj->product_desc}</div>
                        <div class="product-info">
                            Price {$currency}{$obj->price}
                            <fieldset>
                                <label>
                                    <span>Color</span>
                                    <select name="product_color">
                                        <option value="Black">Black</option>
                                        <option value="Silver">Silver</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Quantity</span>
                                    <input type="text" size="2" maxlength="2" name="product_qty" value="1" />
                                </label>
                            </fieldset>
                            <input type="hidden" name="product_code" value="{$obj->product_code}" />
                            <input type="hidden" name="type" value="add" />
                            <input type="hidden" name="return_url" value="{$current_url}" />
                            <div align="center"><button type="submit" class="add_to_cart">Add</button></div>
                        </div>
                    </div>
                </form>
            </li>
            EOT;
        }
        $products_item .= '</ul>';
        echo $products_item;
    }
} catch (PDOException $e) {
    die('Error : ' . $e->getMessage());
}
?>

<!-- Products List End -->
</body>
</html>
