<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .footer {
            color: #d9d9d9;
            background-color: #323232;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px 8vw;
            padding-top: 80px;
            margin-top: 100px;
        }

        .footer-content {
            width: 100%;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 80px;
        }

        .footer-content-left,
        .footer-content-right,
        .footer-content-center {
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 20px;
        }

        .footer-content-left li,
        .footer-content-right li,
        .footer-content-center li {
            list-style: none;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .footer-content-right h2,
        .footer-content-center h2 {
            color: white;
        }

        .footer-social-icon i {
            font-size: 30px;
            margin-right: 25px;
        }

        .footer hr {
            width: 100%;
            height: 2px;
            margin: 20px 0;
            background-color: grey;
            border: none;
        }

        .logo {
            font-size: 25px;
            font-weight: 500;
            cursor: pointer;
        }

        @media (width<750px) {
            .footer-content {
                display: flex;
                flex-direction: column;
                gap: 35px;
            }

            .footer-copyright {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class='footer' id='footer'>
        <div class="footer-content">
            <div class="footer-content-left">
                <div class="logo">Cartify</div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur quam facere, possimus modi tenetur
                    voluptate, ut libero doloribus optio incidunt voluptas eum doloremque aliquid quibusdam
                    exercitationem,
                    quae quos totam fugit.</p>
                <div class="footer-social-icon">
                    <i class="fab fa-facebook"></i><i class="fab fa-twitter"></i><i class="fab fa-linkedin"></i>
                </div>
            </div>
            <div class="footer-content-center">
                <h2>Company</h2>
                <ul>
                    <li>Home</li>
                    <li>About us</li>
                    <li>Delivery</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
            <div class="footer-content-right">
                <h2>Get in Touch</h2>
                <ul>
                    <li>+91 9786 543 210</li>
                    <li>booking@cartify.com</li>
                </ul>
            </div>
        </div>
        <hr />
        <p class="footer-copyright">
            Copyright 2024 &copy; cartify.com - All Right Reserved
        </p>
    </div>
</body>

</html>