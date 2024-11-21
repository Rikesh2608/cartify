<?php
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['mobile_user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['mobile_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $cart_id = intval($_POST['cart_id']);
    $delete_sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

$sql = "
    SELECT 
        cart.cart_id AS cart_id, 
        product.id AS product_id, 
        product.name, 
        product.brand, 
        product.price, 
        product.image, 
        cart.quantity
    FROM 
        cart
    INNER JOIN 
        product
    ON 
        cart.product_id = product.id
    WHERE 
        cart.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        .cart-page {
            padding: 30px 50px;
            display: flex;
            gap: 50px;
        }

        .cart-left {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 600px;
            max-width: 600px;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            align-items: center;
        }

        .cart-item img {
            max-width: 100px;
            border-radius: 5px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-details h3 {
            margin: 0;
            font-size: 18px;
        }

        .cart-item-details p {
            margin: 5px 0;
        }

        .cart-item-total {
            font-weight: bold;
        }

        .checkout {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .checkout button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-right{
            flex: 1;
        }
        .cart-total {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-total-details {
            display: flex;
            justify-content: space-between;
            color: #555;
        }

        .cart-total hr {
            margin: 10px 0;
        }

        .cart-total button,.cart-item-remove {
            border: none;
            color: white;
            background-color: #333;
            width: max(15vw, 200px);
            padding: 12px 0;
            border-radius: 4px;
            cursor: pointer;
        }
        .cart-total button{
            align-self: center;
        }
        .cart-item-remove{
            background-color: tomato;
        }
        .cart-promocode {
            flex: 1;
        }

        .cart-promocode p {
            color: #555;
        }

        .cart-promocode-input {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #eaeaea;
            border-radius: 4px;
        }

        .cart-promocode-input input {
            background-color: transparent;
            border: none;
            outline: none;
            padding-left: 10px;
        }

        .cart-promocode-input button {
            width: max(10vw, 150px);
            padding: 12px 5px;
            background-color: black;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        @media (width<750px) {
            .cart-bottom {
                flex-direction: column-reverse;
            }

            .cart-promocode {
                justify-content: start;
            }
        }
    </style>
</head>

<body>
    <div class="cart-page">
        <div class="cart-left">
            <h1>Your Cart</h1>
            <div class="cart-container">
                <?php
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    $subtotal = $row['price'] * $row['quantity'];
                    $total += $subtotal;
                    echo "
                    <div class='cart-item'>
                        <img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>
                        <div class='cart-item-details'>
                            <h3>" . htmlspecialchars($row['name']) . "</h3>
                            <p>" . htmlspecialchars($row['brand']) . "</p>
                            <p>Price: $" . number_format($row['price'], 2) . "</p>
                            <p>Quantity: " . htmlspecialchars($row['quantity']) . "</p>
                            <p class='cart-item-total'>Subtotal: $" . number_format($subtotal, 2) . "</p>
                            <form method='POST'>
                                <input type='hidden' name='cart_id' value='" . $row['cart_id'] . "' />
                                <button type='submit' name='remove_item' class='cart-item-remove'>Remove</button>
                            </form>
                        </div>
                    </div>";
                }
                ?>     
            </div>
        </div>
        <div class=cart-right>
            <div class="cart-total">
                <h2>Cart Total</h2>
                <div>
                    <div class="cart-total-details">
                        <p>Subtotal</p>
                        <p>$<?php echo $total ?></p>
                    </div>
                    <hr />
                    <div class="cart-total-details">
                        <p>Delivery Fee</p>
                        <p>$<?php if ($total > 0) {
                            echo "2.00";
                        } else {
                            echo "0.00";
                        } ?></p>
                    </div>
                    <hr />
                    <div class="cart-total-details">
                        <b>Total</b>
                        <b>$<?php if ($total > 0) {
                            echo $total + 2;
                        } else {
                            echo "0.00";
                        } ?></b>
                    </div>
                </div>
                <button><a href="order.php" style="color:white; text-decoration:none">Proceed to Checkout</a></button>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>

</html>
