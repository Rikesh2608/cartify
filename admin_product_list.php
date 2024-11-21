<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    include "db.php";
    include "admin_header.php";
    ?>
    <div class="products-container" style="padding:50px 40px;">
        <?php
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <div class='product-overview'>
                        <div class='product-img'>
                            <img src='".$row['image']."' alt=''>
                        </div>
                        <div class='product-overview-bottom'>
                            <div class='product-details'>
                                <div class='product-name'>".$row['name']."</div>
                                <div class='product-desc'>".$row['brand']."</div>
                                <div class='product-price'>$".$row['price']."</div>
                            </div>
                            <div class='product-buttons-container'>
                                <a class='update' style=\"color:white; text-align:center; border-radius: 5px;cursor: pointer;padding: 10px 0px; text-decoration:none;\"
                                href=\"update.php?id=".$row['id']."\"
                                >update</a>
                                <button onclick=\"confirmDelete(" . $row['id'] . ")\">Delete</button>
                            </div>
                        </div>
                    </div>
                    ";
            }
        }
        ?>
    </div>
    <?php include "footer.php"?>

    <script>
        function confirmDelete(id){
            window.location.href=`delete_product.php?id=${id}`
        }
    </script>
</body>
</html>