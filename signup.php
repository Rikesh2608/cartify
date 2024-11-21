<?php 
    include "db.php";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_name = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $user_name, $email, $hashed_password);

        
    
        if ($stmt->execute()) {
            $sql = "SELECT user_id, name FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            session_set_cookie_params(24*60*60*10);
            $_SESSION['mobile_user_id'] = $row['user_id'];
            $_SESSION['mobile_user_name'] = $row['name'];
            
            echo "<script>alert('Account Created Successfully');
            window.location.href = 'home.php';</script>";
            exit;
        } else {
            echo "<script>alert('Something went wrong! Please try again.');
            window.location.href = 'signup.php';</script>";
        }
    
        // Close the statement and connection
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
            background: url("assets/banner2.svg");
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
        <form class="login-form" method="POST">
            <h1>
                Create an Account
            </h1>
            <div>
                <div>Username</div>
                <div>
                    <input type="text" required placeholder="Enter Username" name="username">
                </div>
            </div>
            <div>
                <div>Email</div>
                <div>
                    <input type="email" required placeholder="Enter Email" name="email">
                </div>
            </div>
            <div>
                <div>Password</div>
                <div>
                    <input type="password" required placeholder="Enter Password" name="password">
                </div>
            </div>
            <div class="form-bottom">
                <a href="login.php">Login</a>
                <button>Signup</button>
            </div>
        </form>
    </div>
    <?php include "footer.php"?>

</body>

</html>