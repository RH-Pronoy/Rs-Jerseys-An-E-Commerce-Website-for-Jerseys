<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RS Jerseys</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
     background-image: url('background-for-website.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.4);
    }

    /* Header Styles */
    header {
      animation: fadeInDown 1s ease;
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      box-sizing: border-box;
      border-bottom: 2px solid #ffcd00;
    }

    /* Logo Styles */
    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      max-height: 60px;
      margin-right: 10px;
    }

    .logo h1 {
      font-size: 2em;
      margin: 0;
    }

    /* Navigation Styles */
    nav ul {
      list-style-type: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      display: inline-block;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }

    nav ul li a:hover {
      background-color: #ffcd00;
      color: #000;
    }

    /* Account and Cart Button Styles */
    .account-button a, .cart-button a {
      color: #fff;
      font-size: 1.2em;
    }

    /* Main Content Styles */
    main {
      width: 100%;
      padding: 30px;
      box-sizing: border-box;
    }

    /* Banner Image */
    .banner {
      text-align: center;
      margin-bottom: 30px;
    }

    .banner img {
      max-width: 55%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Product Grid */
    .products {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      gap: 20px;
    }

    .product {
      flex: 1 1 calc(30% - 20px);
      max-width: calc(30% - 20px);
      padding: 20px;
      text-align: center;
      background: rgba(255, 255, 255, 0.01);
      backdrop-filter: blur(8px);
      border-radius: 10px;
      transition: transform 0.3s ease;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .product:hover {
      transform: translateY(-5px);
    }

    .product img {
      max-width: 100%;
      height: 170px;
      border-radius: 10px;
    }

    .product h3 {
      margin: 15px 0;
      font-size: 18px;
      color: #fff;
    }

    .product p {
      margin: 5px 0;
      font-size: 16px;
      color: #fff;
    }

    .product button {
      padding: 10px 20px;
      background-color: #002e91;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .product button:hover {
      background-color: #740101;
    }

    /* Footer Styles */
    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 20px;
      text-align: center;
      border-top: 3px solid #ffcd00;
      width: 97.4%;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      nav ul {
        flex-direction: column;
        gap: 10px;
      }

      .product {
        flex: 1 1 calc(45% - 20px);
        max-width: calc(45% - 20px);
      }
    }

    @media (max-width: 768px) {
      nav ul {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }

      .banner img {
        max-width: 80%;
      }

      .products {
        flex-direction: column;
        align-items: center;
      }

      .product {
        flex: 1 1 100%;
        max-width: 100%;
      }
    }

    @media (max-width: 480px) {
      header {
        flex-direction: column;
        text-align: center;
      }

      .logo h1 {
        font-size: 1.5em;
      }

      .banner img {
        max-width: 100%;
      }

      .products {
        flex-direction: column;
      }

      .product {
        max-width: 100%;
      }

      nav ul {
        gap: 5px;
      }
    }

    /* Animation */
    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    h2 {
      text-align: center;
      margin-top: 15px;
      margin-bottom: 15px;
      color: #4B0101;
    }


  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo2-Photoroom.png" alt="RS Jersey Logo">
      <h1>RS Jerseys</h1>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="Season2024-25.php">Season 2024-25</a></li>
        <li><a href="Season2023-24.php">Season 2023-24</a></li>
        <li><a href="National Team.php">National Team</a></li>
        <li><a href="Fan Edition.php">Fan Edition</a></li>
        <li><a href="Retro.php">Retro</a></li>
        <li class="cart-button"><a href="Cart.php"><i class="fa fa-shopping-cart"></i></a></li>
        <li class="account-button"><a href="YourAccount.php"><i class="fas fa-user"></i></a></li>
      </ul>
    </nav>
  </header>

  <main>
</html>


