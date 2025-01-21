<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RS Jersey Point</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('background-for-website.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.5);
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
    .account-button, .cart-button {
      margin-left: 20px;
    }

    .account-button a, .cart-button a {
      color: #fff;
      font-size: 1.2em;
    }

    /* Main Content Styles */
    main {
      padding: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .container {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      padding: 20px;
    }

    .product-info {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 20px;
    }

    .image-gallery {
      width: 45%;
      text-align: center;
    }

    .product-image {
      width: 100%;
      max-width: 300px;
      height: auto;
      margin-bottom: 20px;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .gallery-thumbnails {
      display: flex;
      justify-content: space-evenly;
      gap: 10px;
    }

    .gallery-thumbnails img {
      width: 100px;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s ease;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .gallery-thumbnails img:hover {
      transform: scale(1.05);
    }

    .product-details {
      width: 50%;
    }

    .product-details h2 {
      color: #4B0101;
      margin-bottom: 20px;
    }

    .product-details ul {
      list-style-type: none;
      padding: 0;
    }

    .add-to-cart-btn {
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #002e91;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-to-cart-btn:hover {
      background-color: #740101;
    }

    /* Footer Styles */
    footer {
      background-color: rgba(0, 0, 0, 0.8);
      color: #fff;
      padding: 20px;
      text-align: center;
      margin-top: 30px;
      border-top: 3px solid #ffcd00;
    }

    footer p {
      margin: 5px 0;
    }
/* Review Section Styles */
.review-section {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      padding: 20px;
      margin-top: 30px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .review-section h2 {
      font-size: 1.8em;
      margin-bottom: 20px;
      color: #4B0101;
    }

    .review {
      background-color: rgba(255, 255, 255, 0.4);
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .review h3 {
      margin: 0;
      font-size: 1.2em;
      color: #002e91;
    }

    .review p {
      font-size: 1em;
      line-height: 1.6;
    }

    /* Review Form Styles */
    form#reviewForm {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 20px;
      
    }

    form#reviewForm label {
      font-weight: bold;
      color: #002e91;
    }

    form#reviewForm select,
    form#reviewForm textarea {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      background-color: rgba(255, 255, 255, 0.1);
    }

    form#reviewForm button {
      padding: 10px;
      background-color: #002e91;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1em;
      width: 40%;
      align-items:center;
    }

    form#reviewForm button:hover {
      background-color: #740101;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        text-align: center;
      }

      .product-info {
        flex-direction: column;
        align-items: center;
      }

      .image-gallery, .product-details {
        width: 100%;
      }

      .logo h1 {
        font-size: 1.5em;
      }
      .review-section, .review, #reviewForm {
        padding: 15px;
      }

      .review h3 {
        font-size: 1.1em;
      }

      .review p {
        font-size: 0.9em;
      }
    }
    

    @media (max-width: 480px) {
      nav ul {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

      nav ul li {
        margin-bottom: 10px;
      }

      .logo img {
        max-height: 40px;
      }

      .logo h1 {
        font-size: 1.2em;
      }

      .product-image {
        max-width: 200px;
      }
      .review-section, .review {
        padding: 10px;
      }

      .review h3 {
        font-size: 1em;
      }

      .review p {
        font-size: 0.85em;
      }

      form#reviewForm {
        gap: 5px;
      }

      form#reviewForm button {
        font-size: 0.9em;
      }
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
        <li class="cart-button">
          <a href="Cart.php"><i class="fa fa-shopping-cart"></i></a>
        </li>
        <li class="account-button">
          <a href="YourAccount.php"><i class="fas fa-user"></i></a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    </html>