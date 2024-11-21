<?php
    session_start();
    include 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    if(!isset($_SESSION['mobile_user_id'])){
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['mobile_user_id'];

    $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    if(!$stmt->execute()){
        echo "<script>alert('Something went wrong')</script>";
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $update_sql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $row['cart_id']);
        if($update_stmt->execute()){
            echo "<script>alert('Added Succesfully')</script>";
        }else{
            echo "<script>alert('Something went wrong')</script>";
        }
    } else {
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        if($insert_stmt->execute()){
            echo "<script>alert('Added Succesfully')</script>";
        }else{
            echo "<script>alert('Something went wrong')</script>";
        }
    }
    header("Location: home.php#shop");
} else {
    echo "Invalid request.";
}
?>