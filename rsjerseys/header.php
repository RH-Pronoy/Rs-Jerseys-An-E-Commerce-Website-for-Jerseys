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

    /* Logo and Drawer Toggle */
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
    .drawer-toggle {
      font-size: 2em;
      cursor: pointer;
      display: none;
    }

    /* Drawer Menu */
    .drawer {
      position: fixed;
      top: 0;
      left: -100%;
      width: 75%;
      max-width: 300px;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      color: #fff;
      transition: left 0.3s ease;
      padding: 20px;
      box-sizing: border-box;
      z-index: 1000;
    }

    .drawer.active {
      left: 0;
    }

    .drawer ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .drawer ul li {
      margin-bottom: 20px;
    }

    .drawer ul li a {
      color: #fff;
      text-decoration: none;
      font-size: 1.5em;
      display: block;
    }

    .close-drawer {
      font-size: 1.5em;
      cursor: pointer;
      position: absolute;
      top: 20px;
      right: 20px;
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
      gap: 18px;
    }

    .product {
      flex: 1 1 calc(28% - 20px);
      max-width: calc(25% - 19px);
      padding: 19px;
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
    /* Responsive Design */
    @media (max-width: 768px) {
      .drawer-toggle {
        display: block;
      }

      nav ul {
        display: none;
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
    }
   
    /* Footer Styles */
    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 20px;
      text-align: center;
      border-top: 3px solid #ffcd00;
      width: 97%;
    }
  </style>
</head>
<body>

<header>
    <div class="logo">
      <img src="logo2-Photoroom.png" alt="RS Jersey Logo">
      <h1>RS Jerseys</h1>
    </div>
    <!-- Drawer toggle button for mobile -->
    <i class="fas fa-bars drawer-toggle"></i>

    <!-- Desktop Navigation -->
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

    <!-- Drawer Menu for Mobile -->
    <div class="drawer" id="drawer">
      <span class="close-drawer" id="closeDrawer">&times;</span>
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
    </div>
  </header>

  <main>
    <!-- Content here -->
  </main>


  <script>
    // Toggle the drawer
    const drawerToggle = document.querySelector('.drawer-toggle');
    const drawer = document.getElementById('drawer');
    const closeDrawer = document.getElementById('closeDrawer');

    drawerToggle.addEventListener('click', function() {
      drawer.classList.add('active');
    });

    closeDrawer.addEventListener('click', function() {
      drawer.classList.remove('active');
    });

    // Close the drawer if the user clicks outside
    document.addEventListener('click', function(event) {
      if (!drawer.contains(event.target) && !drawerToggle.contains(event.target)) {
        drawer.classList.remove('active');
      }
    });
  </script>
</body>
</html>
