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
            background: url("assets/banner1.svg");
            background-size: 50%;
            background-position: right;
            background-repeat: no-repeat;
            font-family: 'Outfit';
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 30px 50px;
        }
        form div {
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
        .price-container {
            display: flex;
            flex-direction: row;
            max-width: 300px;
            gap: 20px;
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
            max-width: 150px;
            border: 1px solid #ddd;
            padding: 5px;
            display: none;
        }
    </style>
    <title>Cartify</title>
</head>
<body>
    <?php 
    include 'admin_header.php';
    include 'db.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $price = floatval($_POST['price']); 

        $img_link = $_FILES['img']['name'];
        $target_dir = "images/"; 
        $target_file = $target_dir . basename($img_link);
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); 
        }

        if ($_FILES['img']['error'] !== UPLOAD_ERR_OK) {
            die("Error uploading file. Error code: " . $_FILES['img']['error']);
        }

        if (!move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            die("Sorry, there was an error uploading your file. Please try again.");
        }

        $sql = "INSERT INTO product (name, brand, price, image) VALUES ('$name', '$brand', $price, '$target_file')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('New product added successfully!')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="img">Upload Image</label>
            <input type="file" required id="img" name="img" class="img-file" accept="image/*" onchange="previewImage()">
            <img id="image-preview" alt="Selected Image Preview">
        </div>
        <div>
            <label for="name">Product name</label>
            <input type="text" required name="name" id="name" placeholder="Type here">
        </div>
        <div>
            <label for="brand">Product brand</label>
            <input name="brand" id="brand" required placeholder="Type here">
        </div>
        <div>
            <label for="price">Product Price</label>
            <input type="number" required min="0" step="0.01" placeholder="$0" max="1000" name="price" id="price">
        </div>
        <div>
            <button type="submit">ADD</button>
        </div>
    </form>

    <?php include "footer.php"?>

    <script>
        function previewImage() {
            const file = document.getElementById('img').files[0];
            const preview = document.getElementById('image-preview');
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = 'none'; 
            }
        }
    </script>
</body>
</html>
