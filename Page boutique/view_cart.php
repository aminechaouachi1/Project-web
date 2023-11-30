<?php
session_start();
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View shopping cart</title>
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
<div class="cart-view-table-back">
    <form method="post" action="cart_update.php">
        <table width="100%" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION["cart_products"])) {
                    $total = 0;
                    $b = 0;

                    try {
                        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        foreach ($_SESSION["cart_products"] as $cart_itm) {
                            $product_code = $cart_itm["product_code"];
                            $stmt = $pdo->prepare("SELECT * FROM products WHERE product_code = ?");
                            $stmt->execute([$product_code]);
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($product) {
                                $product_name = $product["product_name"];
                                $product_qty = $cart_itm["product_qty"];
                                $product_price = $product["price"];
                                $subtotal = ($product_price * $product_qty);

                                $bg_color = ($b++ % 2 == 1) ? 'odd' : 'even';

                                echo '<tr class="' . $bg_color . '">';
                                echo '<td><input type="text" size="2" maxlength="2" name="product_qty[' . $product_code . ']" value="' . $product_qty . '" /></td>';
                                echo '<td>' . $product_name . '</td>';
                                echo '<td>' . $currency . $product_price . '</td>';
                                echo '<td>' . $currency . $subtotal . '</td>';
                                echo '<td><input type="checkbox" name="remove_code[]" value="' . $product_code . '" /></td>';
                                echo '</tr>';

                                $total += $subtotal;

                                // Insert/update cart items in the database
                                $stmt = $pdo->prepare("INSERT INTO cart (product_code, product_name, product_qty, product_price, subtotal) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE product_qty = VALUES(product_qty), subtotal = VALUES(subtotal)");

                                $stmt->execute([ $product_code, $product_name, $product_qty, $product_price, $subtotal]);
                            }
                        }

                        $grand_total = $total + $shipping_cost;

                        foreach ($taxes as $key => $value) {
                            $tax_amount = round($total * ($value / 100));
                            $tax_item[$key] = $tax_amount;
                            $grand_total += $tax_amount;
                        }

                        $list_tax = '';
                        foreach ($tax_item as $key => $value) {
                            $list_tax .= $key . ' : ' . $currency . sprintf("%01.2f", $value) . '<br />';
                        }

                        $shipping_cost = ($shipping_cost) ? 'Shipping Cost : ' . $currency . sprintf("%01.2f", $shipping_cost) . '<br />' : '';
                    } catch (PDOException $e) {
                        die('Error : ' . $e->getMessage());
                    }
                }
                ?>

                <tr>
                    <td colspan="5">
                        <span style="float:right;text-align: right;"><?php echo $shipping_cost . $list_tax; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total); ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <a href="index.php" class="button">Add More Items</a><button type="submit">Update</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="return_url" value="<?php
                                                        $current_url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                                                        echo $current_url; ?>" />
    </form>
</div>

</body>
</html>
