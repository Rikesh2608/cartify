<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        p{
            margin: 0;
            font-weight: 500;
        }
        main{
            display: flex;
            flex-wrap: wrap;
            gap: 20px 40px;
            padding: 30px 50px;
        }
        .user-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            gap: 10px;
            box-shadow: 0px 0px 12px rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 10px;
        }
        .user-container > img{
            max-width: 150px;
        }
    </style>
</head>
<body>
    <?php 
    include "admin_header.php";
    include 'db.php'; 
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);
    ?>
    <main>
        
        <?php 
            while ($row = $result->fetch_assoc()) {
                echo "<div class='user-container'>
                        <img src='assets/user-avatar.jpg'>
                        <p>Id : {$row['user_id']}</p>
                        <p>{$row['name']}</p>
                        <p>{$row['email']}</p>
                    </div>";
            }
        ?>
    </main>
    <?php include "footer.php"?>

</body>
</html>