<?php 
    session_start();
    include "db.php";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $sql = "SELECT user_id, name, password FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            if (password_verify($password, $row['password'])) {
                session_set_cookie_params(24*60*60*10);
                $_SESSION['mobile_user_id'] = $row['user_id'];
                $_SESSION['mobile_user_name'] = $row['name'];
                    
                header("Location: home.php");
                exit;
            } else {
                echo "<script>alert('Invalid password!');</script>";
            }
        } else {
            echo "<script>alert('Email not found!');</script>";
        }
    
        $stmt->close();
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            min-height: 100vh;
        }
        .login-page{
            background: url("assets/banner1.svg");
            background-position: right;
            background-size: 50%;
            background-repeat: no-repeat;
            padding: 20px 50px;
        }
        form.login-form{
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px;
        }
        h1{
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        input{
            padding: 10px;
            border: 1px solid ;
            border-radius: 5px;
            margin: 10px 0;
            width: 250px;
        }
        a{
            color: inherit;
            text-decoration: none;
            font-weight: 500;
        }
        .form-bottom{
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            max-width: 270px;
            margin-top: 40px;
        }
        button{
            font-size: 14px;
            padding:10px 15px;
            cursor: pointer;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Cartify</div>
    </header>
    <div class="login-page">
    <form class="login-form" action="login.php" method="POST">
    <h1>
        Login
    </h1>
    <div>
        <div>Email</div>
        <div>
            <input type="email" name="email" required placeholder="Enter Email">
        </div>
    </div>
    <div>
        <div>Password</div>
        <div>
            <input type="password" name="password" required placeholder="Enter Password">
        </div>
    </div>
    <div class="form-bottom">
        <a href="signup.php">Create an account</a>
        <button type="submit">Login</button>
    </div>
</form>

    </div>
    <?php include "footer.php"?>
</body>
</html>