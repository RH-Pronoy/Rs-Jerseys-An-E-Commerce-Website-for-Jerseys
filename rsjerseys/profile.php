<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch additional user details from the database
$conn = new mysqli("localhost", "root", "", "rsjersey");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email, dob, address, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $dob, $address, $phone);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RS Jerseys</title>
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
      padding: 30px;
    }

    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 20px;
      text-align: center;
      margin-top: 30px;
      border-top: 3px solid #ffcd00;
    }

    footer p {
      margin: 5px 0;
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

    
    /* Centering the headers */
    h2, .wrapper h1 {
      text-align: center;
      margin-top: 15px;
      margin-bottom: 15px;
      color: #4B0101;
    }
       
.container {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    gap: 20px;
    padding: 60px 30px;
    background: transparent;
}

.profile-sidebar, .profile-sidebar-right {
    background: transparent;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    backdrop-filter: blur(20px)
}

.profile-sidebar img, .profile-sidebar-right img {
    
    width: 220px;
    height: 150px;
    border: 3px solid #007BFF;
}

.profile-sidebar h2 {
    font-size: 22px;
    color: blue;
    margin: 10px 0;
}

.profile-sidebar-right {
    background: transparent;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    backdrop-filter: blur(20px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.profile-sidebar-right a {
    background-color: purple;
    color: #fff;
    transition: background-color 0.3s, box-shadow 0.3s;
    text-align: center;
    width: 80%;
    align-items: center;
    display: flex;
    justify-content: center;
    text-decoration: none;
}

.profile-sidebar-right a:hover {
    background-color: #c82333;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.5);
}

.profile-sidebar-right button, .profile-sidebar-right a {
    margin-bottom: 20px; /* Added margin for spacing */
}

.profile-sidebar-right img {
    margin-bottom: 20px;
}



.profile-content {
    background: transparent;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    font-size: 18px;
    backdrop-filter: blur(20px)
}

button, input {
    font-family: 'Poppins', sans-serif;
}


  /* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000; /* Increased z-index to ensure modal is above other elements */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7); /* Darker background for better contrast */
}

.modal-content {
    background: #fff; /* White background for content */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    margin: auto;
    max-width: 600px; /* Limit the width of the modal */
    animation: fadeIn 0.3s ease; /* Animation on opening */
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #ffcd00; /* Gold border for header */
    padding-bottom: 10px;
}

.modal-header h2 {
    margin: 0;
    font-size: 24px;
    color: #333; /* Dark text for better readability */
}

.modal-close {
    cursor: pointer;
    font-size: 28px;
    font-weight: bold;
    color: #ff5733; /* A noticeable close button color */
}

.modal-close:hover {
    color: #c0392b; /* Darker shade on hover */
}

.modal-body {
    padding: 20px 0;
}

.modal-body p {
    font-size: 16px;
    color: #555; /* Soft text color for description */
}

.modal-body table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.modal-body table th, .modal-body table td {
    padding: 12px; /* Increased padding for table cells */
    text-align: left;
    border: 1px solid #ddd; /* Light gray border for table */
}

.modal-body table th {
    background-color: #f2f2f2; /* Light gray background for table headers */
}

.modal-body button {
    margin-top: 15px; /* Space between the button and the table */
    padding: 10px 15px;
    background-color: #007BFF; /* Primary button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-body button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}




        .modal-close {
            cursor: pointer;
            font-size: 28px;
            font-weight: bold;
            color: red;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: blue;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px 0;
        }

        .modal-body input[type="text"],
        .modal-body input[type="email"],
        .modal-body input[type="date"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-body button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-body button:hover {
            background-color: #218838;
        }
        input[type="text"], input[type="email"], input[type="date"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    transition: 0.3s;
  
}

input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus {
    border-color: #ff5722;
    box-shadow: 0 0 8px rgba(255, 87, 34, 0.4);
}


/* Edit and Log Out Button Styles */
button{
    font-family: 'Poppins', sans-serif;
    padding: 12px 10px;
    font-size: 1em;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
}
a {
    font-family: 'Poppins', sans-serif;
    padding: 12px 0px;
    font-size: 1em;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
}

#updateProfileBtn {
    background-color: #28a745;
    color: #fff;
    transition: background-color 0.3s, box-shadow 0.3s;
}

#updateProfileBtn:hover {
    background-color: #218838;
    box-shadow: 0 4px 15px rgba(33, 136, 56, 0.5);
}

.my-orders-btn {
  background-color: #007BFF;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.my-orders-btn:hover {
  background-color: #0056b3;
  box-shadow: 0 4px 15px rgba(0, 87, 255, 0.5);
}

.my-orders-btn:active {
  background-color: #0047b3;
  box-shadow: 0 2px 10px rgba(0, 87, 255, 0.5);
}


        /* Media Queries */
/* Responsive styles for all devices */

/* For devices with width of 1200px or higher (large screens) */
@media (min-width: 1200px) {
  .container {
    grid-template-columns: 1fr 2fr 1fr;
  }
  .profile-sidebar, .profile-sidebar-right {
    padding: 30px;
  }
  header h1 {
    font-size: 2.5em;
  }
}

/* For devices between 768px and 1200px (tablets and small laptops) */
@media (min-width: 768px) and (max-width: 1199px) {
  .container {
    grid-template-columns: 1fr 2fr;
  }
  .profile-sidebar, .profile-sidebar-right {
    padding: 20px;
  }
  .profile-sidebar img, .profile-sidebar-right img {
    width: 180px;
    height: 120px;
  }
  header h1 {
    font-size: 2em;
  }
}

/* For devices between 480px and 767px (tablets in portrait mode) */
@media (min-width: 480px) and (max-width: 767px) {
  .container {
    grid-template-columns: 1fr;
  }
  .profile-sidebar, .profile-sidebar-right {
    margin-bottom: 20px;
    padding: 15px;
  }
  .profile-content {
    padding: 20px;
  }
  .profile-sidebar img, .profile-sidebar-right img {
    width: 150px;
    height: 100px;
  }
  header h1 {
    font-size: 1.8em;
  }
}

/* For devices with width below 480px (mobile phones) */
@media (max-width: 479px) {
  header {
    flex-direction: column;
    text-align: center;
  }
  header h1 {
    font-size: 1em;
    margin-bottom: 15px;
  }
  nav ul {
    flex-direction: column;
    gap: 10px;
  }
  .container {
    grid-template-columns: 1fr;
    padding: 10px;
  }
  .profile-sidebar, .profile-sidebar-right {
    padding: 10px;
    margin-bottom: 15px;
  }
  .profile-sidebar img, .profile-sidebar-right img {
    width: 120px;
    height: 80px;
  }
  .profile-content {
    padding: 15px;
  }
  footer p {
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
          <a href="Cart.php">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
          </a>
        </li>
        <li class="account-button">
          <a href="YourAccount.php">
            <i class="fas fa-user"></i>
          </a>
        </li>
      </ul>
    </nav>
  </header>
 
<div class="container">
    <!-- Left Sidebar (Profile Info) -->
    <div class="profile-sidebar">
        <img src="pro.jpeg" alt="Profile Picture">
        <br><br>
        <h2>Welcome, <br><?php echo htmlspecialchars($user_name); ?>!</h2>
        
    </div>

    <!-- Center Content (Empty or Additional Info) -->
    <div class="profile-content">
    <h2>Profile Info:</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <button id="updateProfileBtn">Edit Profile</button>
    </div>

    <!-- Right Sidebar (Orders and Logout) -->
    <div class="profile-sidebar-right">
        <img src="pro2.jpeg" alt="Profile Picture">
        <br><br>
        <button class="my-orders-btn">My Orders</button>
        <br><br>
        <a href="logout.php">Log Out</a>
    </div>
</div>
<!-- Orders Modal -->
<div id="ordersModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>My Orders</h2>
            <span class="modal-close" id="ordersModalCloseBtn">&times;</span>
        </div>
        <div class="modal-body" id="ordersModalBody">
            <!-- Orders will be loaded here -->
            <p>Loading orders...</p>
        </div>
    </div>
</div>


    <!-- Modal for updating profile -->
    <div id="updateProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Profile</h2>
                <span class="modal-close" id="modalCloseBtn">&times;</span>
            </div>
            <div class="modal-body">
            <form action="update_profile.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user_name); ?>" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
    <br>
    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
    <br>
    <label for="address">Address:</label>
    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address); ?>" required>
    <br>
    <label for="phone">Phone:</label> <!-- Ensure name="phone" matches -->
    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" required> <!-- Changed to 'phone' -->
    <button type="submit">Update</button>
</form>

            </div>
        </div>
    </div>

    <script>
   // Get the modal
var modal = document.getElementById("updateProfileModal");

// Get the button that opens the modal
var btn = document.getElementById("updateProfileBtn");

// Get the <span> element that closes the modal
var span = document.getElementById("modalCloseBtn");

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "flex"; // Center the modal
    document.querySelector('.modal-content').classList.add('show'); // Show modal with animation
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    document.querySelector('.modal-content').classList.remove('show'); // Reset animation state
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.querySelector('.modal-content').classList.remove('show'); // Reset animation state
    }
}


// Get the Orders modal
var ordersModal = document.getElementById("ordersModal");

// Get the button that opens the modal
var ordersBtn = document.querySelector(".profile-sidebar-right button");

// Get the <span> element that closes the modal
var ordersCloseBtn = document.getElementById("ordersModalCloseBtn");

// When the user clicks the button, open the orders modal// Fetch the user's orders via AJAX
ordersBtn.onclick = function() {
    ordersModal.style.display = "flex";
    document.querySelector('#ordersModal .modal-content').classList.add('show');

    fetch('fetch_orders.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            let ordersHTML = '';
            data.orders.forEach(order => {
                ordersHTML += `
                    <h3>Order ID: ${order.order_id}</h3>
                    <p><strong>Total Price:</strong> ${order.total_price}৳</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${order.items.map(item => `
                                <tr>
                                    <td>${item.product_name}</td>
                                    <td>${item.size}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price}৳</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
${order.order_status === 'Pending' ? `<button onclick="cancelOrder(${order.order_id})">Cancel Order</button>` : ''}
                    <hr />
                `;
            });
            document.getElementById('ordersModalBody').innerHTML = ordersHTML;
        } else {
            document.getElementById('ordersModalBody').innerHTML = '<p>No orders found.</p>';
        }
    });

};

// Function to cancel the order
function cancelOrder(orderId) {
    fetch(`cancel_order.php?order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Order canceled successfully');
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Error canceling order: ' + data.message);
            }
        });
}

// When the user clicks on <span> (x), close the modal
ordersCloseBtn.onclick = function() {
    ordersModal.style.display = "none";
    document.querySelector('#ordersModal .modal-content').classList.remove('show');
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == ordersModal) {
        ordersModal.style.display = "none";
        document.querySelector('#ordersModal .modal-content').classList.remove('show');
    }
}
    </script>
</body>
</html>
<?php include('footer.php'); ?>
