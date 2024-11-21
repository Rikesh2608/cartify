<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        .product-quantity input {
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php 
    session_start();
    include "header.php";
    include 'db.php';
    ?>
    <main>
        <section class="hero">
            <div>
                <div class="content-header">Don’t Wait, Upgrade!</div>
                <div class="content-about">
                FIND YOUR PERFECT MOBILE WITH US.
                </div>
                <div class="content-desc">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo tenetur tempora rerum ex, voluptatibus
                    fuga, impedit odio consequuntur est, facilis ab iusto debitis! Aliquam obcaecati debitis quae
                    repellat, eveniet fugiat!
                </div>
                <button>About Us</button>
            </div>
        </section>
        <section class="products-section" id="shop">
            <h1>See our products</h1>
            <div class="products-container">
                <?php
                $sql = "SELECT * FROM product";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                            <div class='product-overview'>
                                <div class='product-img'>
                                    <img src='" . $row['image'] . "' alt=''>
                                </div>
                                <div class='product-overview-bottom'>
                                    <div class='product-details'>
                                        <div class='product-name'>" . $row['name'] . "</div>
                                        <div class='product-desc'>" . $row['brand'] . "</div>
                                        <div class='product-price'>$" . $row['price'] . "</div>
                                    </div>
                                    <div class='product-buttons-container'>
                                        <form method='POST' action='add_to_cart.php'>
                                            <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                            <div class='product-quantity'>
                                                <div>Quantity : </div>
                                                <input type='number' name='quantity' value='1' min='1' style='width: 60px;'>
                                            </div>
                                            <button type='submit'>Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ";
                    }
                }
                ?>
            </div>
        </section>
    </main>
    <?php include "footer.php"?>
</body>

</html>