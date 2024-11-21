<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify - Admin Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
        body{
            margin: 0;
        }
        header {
            font-family: 'Rubik';
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            padding: 15px 40px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
            color: #333;
            background-color: white;
        }

        .logo {
            font-size: 25px;
            font-weight: 500;
            cursor: pointer;
        }

        .header-list {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-list>a.pages {
            color: #333;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <header>
        <div class="logo">
            Cartify Admin
        </div>
        <div class="header-list">
            <a class="pages" href="admin_product_list.php">Products</a>
            <a class="pages" href="add_product.php">Add</a>
            <a class="pages" href="admin_user_list.php">Users</a>
            <a class="pages" href="#">Orders</a>
        </div>
    </header>
</body>

</html>