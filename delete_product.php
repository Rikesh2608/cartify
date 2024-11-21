<?php
    include 'db.php'; 
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']); 

        $sql = "SELECT image FROM product WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_path = $row['image'];
            
            // Delete the image file
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $delete_sql = "DELETE FROM product WHERE id = '$id'";
            if (mysqli_query($conn, $delete_sql)) {
                header("Location: admin_product_list.php?message=ProductDeleted");
            } else {
                header("Location: admin_product_list.php?error=ProductDeleteFailed");
            }
        } else {
            header("Location: admin_product_list.php?error=ProductNotFound");
        }
    } else {
        // No product ID provided
        header("Location: admin_product_list.php?error=NoProductID");
    }
    exit; // Make sure to exit after redirection
?>
