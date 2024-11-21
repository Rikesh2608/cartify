<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify</title>
    <style>
        form {
            padding: 30px 50px;
        }

        .place-order {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 50px;
            margin-top: 40px;
        }

        .place-order-left {
            width: 100%;
            max-width: max(30%, 500px);
        }

        .place-order-left .title {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 50px;
        }

        .place-order-left input {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            outline-color: tomato;
            border: 1px solid #c5c5c5;
            border-radius: 4px;
        }

        .place-order-left>input {
            width: calc(100% - 20px);
        }

        .place-order-left .multi-fields {
            display: flex;
            gap: 10px;
        }

        .place-order-right {
            width: 100%;
            max-width: max(40%, 500px);
        }

        .place-order .cart-total {
            margin-top: 30px;
        }

        .cart {
            margin-top: 100px;
        }

        .cart-items-title {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 0.5fr;
            align-items: center;
            color: gray;
            font-size: max(1vw, 12px);
        }

        .cart-items-item {
            margin: 10px 0;
            color: black;
        }

        .cart-items-item img {
            width: 50px;
        }

        .cart hr {
            height: 1px;
            background-color: #e2e2e2;
            border: none;
        }

        .cart-items-item .cross {
            cursor: pointer;
        }

        .cart-bottom {
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
            gap: max(12vw, 20px);
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

        .cart-total button {
            border: none;
            color: white;
            background-color: tomato;
            width: max(15vw, 200px);
            padding: 12px 0;
            border-radius: 4px;
            cursor: pointer;
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
    <?php
    include "header.php";
    include "db.php";

    $sql = "
    SELECT 
        SUM(product.price * cart.quantity) AS total_amount
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

    $row = $result->fetch_assoc();
    $total = $row['total_amount'] ?? 0.00;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        echo "<script>alert('Order placed successfully!')</script>";
    }
    ?>
    <form class="place-order" method="POST">
        <div class="place-order-left">
            <p class="title">Delivery Information</p>
            <div class="multi-fields">
                <input type="text" placeholder="First name" required />
                <input type="text" placeholder="Last name" required/>
            </div>
            <input type="text" placeholder="Email Address" required/>
            <input type="text" placeholder="Street" required/>
            <div class="multi-fields">
                <input type="text" placeholder="City" required/>
                <input type="text" placeholder="State" required/>
            </div>
            <div class="multi-fields">
                <input type="text" placeholder="Zip Code" required/>
                <input placeholder="Country" type="text" required/>
            </div>
            <input type="text" placeholder="Phone" required/>
        </div>
        <div class="place-order-right">
            <div class="cart-total">
                <h2>Cart Totals</h2>
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
                <button>Proceed to Payment</button>
            </div>
        </div>
    </form>
</body>

</html>