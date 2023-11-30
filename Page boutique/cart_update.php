<?php
session_start();
include_once("config.php");

// Add product to session or create a new one
if (isset($_POST["type"]) && $_POST["type"] == 'add' && $_POST["product_qty"] > 0) {
    foreach ($_POST as $key => $value) {
        // Add all post vars to new_product array
        $new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }

    // Remove unnecessary vars
    unset($new_product['type']);
    unset($new_product['return_url']);

    // Get product name and price from the database
    try {
        $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT product_name, price FROM products WHERE product_code=? LIMIT 1");
        $statement->bindParam(1, $new_product['product_code']);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $new_product["product_name"] = $result['product_name'];
            $new_product["product_price"] = $result['price'];

            if (isset($_SESSION["cart_products"])) {
                if (isset($_SESSION["cart_products"][$new_product['product_code']])) {
                    unset($_SESSION["cart_products"][$new_product['product_code']]);
                }
            }

            $_SESSION["cart_products"][$new_product['product_code']] = $new_product;
        }
    } catch (PDOException $e) {
        die('Error : ' . $e->getMessage());
    }
}

// Update or remove items
if (isset($_POST["product_qty"]) || isset($_POST["remove_code"])) {
    // Update item quantity in product session
    if (isset($_POST["product_qty"]) && is_array($_POST["product_qty"])) {
        foreach ($_POST["product_qty"] as $key => $value) {
            if (is_numeric($value)) {
                $_SESSION["cart_products"][$key]["product_qty"] = $value;
            }
        }
    }

    // Remove an item from the product session
    if (isset($_POST["remove_code"]) && is_array($_POST["remove_code"])) {
        foreach ($_POST["remove_code"] as $key) {
            unset($_SESSION["cart_products"][$key]);
        }
    }
}

// Back to return url
$return_url = (isset($_POST["return_url"])) ? urldecode($_POST["return_url"]) : '';
header('Location:' . $return_url);
?>
