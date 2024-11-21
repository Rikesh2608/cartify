<?php
include 'db.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = [];

// Fetch product details
if ($product_id > 0) {
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found!");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $price = floatval($_POST['price']);
    
    // Default image path is the current image of the product
    $image_path = $product['image'];

    // Handle image upload if a new image is provided
    if (!empty($_FILES['img']['name'])) {
        $image_name = basename($_FILES['img']['name']);
        $upload_dir = "uploads/";
        $upload_file = $upload_dir . uniqid() . "_" . $image_name;

        // Attempt to move uploaded file
        if (move_uploaded_file($_FILES['img']['tmp_name'], $upload_file)) {
            // Remove old image if a new one is uploaded
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image_path = $upload_file;  // Update the image path to the new image
        } else {
            die("Image upload failed!");
        }
    }

    // Update product details in the database
    $update_sql = "UPDATE product SET name = ?, brand = ?, price = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssdsd", $name, $brand, $price, $image_path, $product_id);

    if ($stmt->execute()) {
        // Redirect to the product list page after successful update
        header("Location: admin_product_list.php?message=ProductUpdated");
        exit;
    } else {
        die("Failed to update product: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
        body {
            min-height: 100vh;
        }
        form {
            background: url("assets/banner2.svg");
            background-size: 50%;
            background-position: right;
            background-repeat: no-repeat;
            font-family: 'Outfit';
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 30px 50px;
        }
        form > div {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            gap: 10px;
        }
        input:not(.img-file), textarea {
            padding: 10px 15px;
            border: 1px solid;
            border-radius: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }
        textarea {
            min-height: 80px;
            resize: none;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: rgba(28,28,28);
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        #image-preview {
            margin-top: 10px;
            max-width: 100px;
        }
    </style>
    <title>Edit Product</title>
</head>
<body>
    <?php include "admin_header.php" ?>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="img">Upload Image</label>
            <input type="file" id="img" name="img" class="img-file" accept="image/*" onchange="previewImage(event)">
            <?php if (!empty($product['image'])): ?>
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" id="image-preview" />
            <?php endif; ?>
        </div>
        <div>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" required placeholder="Type here" value="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div>
            <label for="brand">Product Brand</label>
            <input name="brand" id="brand" required placeholder="Type here" value="<?= htmlspecialchars($product['brand']) ?>">
        </div>
        <div class="price-container">
            <label for="price">Price </label>
            <input type="number" name="price" id="price" required min="0" step="0.01" placeholder="$0" max="1000" value="<?= htmlspecialchars($product['price']) ?>">
        </div>
        <div>
            <button type="submit">Update Product</button>
        </div>
    </form>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result; // Set image preview
            }

            if (file) {
                reader.readAsDataURL(file); // Read the file as a data URL for preview
            }
        }
    </script>
</body>
</html>
