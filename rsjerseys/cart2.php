<?php
session_start();
include('header.php');
include('database_connection.php'); // Include your database connection file

// Ensure user session variables exist
$user_id = $_SESSION['user_id'] ?? null;
$cart = $_SESSION['cart'] ?? [];  // Fallback to empty array if cart is not set

// Function to calculate subtotal
function calculateSubtotal($cart) {
    $subtotal = 0;
    foreach ($cart as $product) {
        $subtotal += $product['price'] * ($product['quantity_m'] + $product['quantity_l'] + $product['quantity_xl'] + $product['quantity_xxl']);
    }
    return $subtotal;
  }
  
  // Function to apply coupon
  function applyCoupon($couponCode, $subtotal) {
    $discountedSubtotal = $subtotal * 0.9;
    $query = "INSERT INTO orders3 (user_id, subtotal, coupon_code) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $_SESSION['user_id'], $discountedSubtotal, $couponCode);
    $stmt->execute();
    return $discountedSubtotal;
  }
  
  // Function to update delivery cost
  function updateDeliveryCost($deliveryOption, $subtotal) {
    $query = "UPDATE orders3 SET delivery_option = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $deliveryOption, $_SESSION['user_id']);
    $stmt->execute();
    return $subtotal;
  }
// Generate a unique order ID
function generateOrderId() {
  return Ramsey\Uuid\Uuid::uuid4()->toString();
}

?>
<style>

  body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('background-for-website.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-color: rgba(0, 0, 0, 0.6);
      color: #fff;
    }

    header {
      width: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      color: #fff;
      padding: 20px 0;
      text-align: center;
      border-bottom: 3px solid #ffcd00;
      top: 0;
      z-index: 1000;
  
    }

    nav ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    nav ul li {
      display: inline;
      margin: 0 10px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: transform 0.3s ease;
    }
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

    nav ul li a:hover {
      transform: scale(1.1);
    }

    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 20px;
      text-align: center;
      margin-top: 30px;
      border-top: 3px solid #ffcd00;
      width: 99%;
    }

    footer p {
      margin: 5px 0;
    }
    main {
      padding: 40px 20px 40px;
      text-align: center;
      width: 95%;
      max-width: 1000px;
      margin: 0 auto;
    }

    .banner img {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .banner img:hover {
      transform: scale(1.05);
    }

    h2 {
      font-size: 36px;
      color: #fffffe;
      margin-bottom: 20px;
    }

    #cart-items {
      background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      margin: 75px auto 20px;
      color: #fff;
      width: 800px;
      max-width: 100%;
    }

    #subtotal {
      text-align: center;
      font-size: 20px;
      margin: 20px 0;
    }

    #checkout-button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 14px 20px;
      border-radius: 40px;
      cursor: pointer;
      width: 70%;
      font-size: 18px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    #checkout-button:hover {
      background-color: #45a049;
      transform: scale(1.05);
    }

    .cart-header,
    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 0;
      border-bottom: 1px solid rgba(255, 255 , 255, 0 .3);
    }

    .cart-header {
      font-weight: bold;
      margin-right: 10px;
      margin-left: 135px;
    }

    .cart-item {
      transition: background-color 0.3s ease;
    }

    .cart-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .cart-item div {
      flex: 1;
      text-align: center;
      padding-left: 20px;
    }

    .cart-item .item-name {
      flex: 2;
      text-align: left;
      padding-left: 20px;
    }

    .cart-item img {
      max-width: 50px;
      margin-right: 10px;
    }

    .cart-item button {
      background-color: #ff4d4d;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .cart-item button:hover {
      background-color: #ff1a1a;
    }

    .quantity-controls button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .quantity-controls button:hover {
      background-color: #45a049;
    }

    .size-selector {
      padding: 5px;
      border-radius: 5px;
      background: #ccc;
      color: #000;
    }

    .subtotal {
    margin-bottom: 20px;
}

.subtotal h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.subtotal p {
    font-size: 24px;
    font-weight: bold;
}

#coupon-section {
    margin-bottom: 20px;
}

#coupon-section h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.coupon-input {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.coupon-input input {
    width: 70%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.coupon-input button {
    width: 25%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#delivery-options {
    margin-bottom: 20px;
}

#delivery-options h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.delivery-options-container {
    display: flex;
    flex-direction: column;
}

.delivery-options-container label {
    margin-bottom: 10px;
}

.delivery-options-container span {
    font-size: 16px;
}

#total-cost {
    margin-bottom: 20px;
}

#total-cost h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

#total-cost p {
    font-size: 24px;
    font-weight: bold;
}

#checkout-btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
    /* Modal Styles */
 /* Checkout Button */
#checkout-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 14px 20px;
    border-radius: 40px;
    cursor: pointer;
    width:  70%;
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-top: 20px;
}

#checkout-btn:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: transparent;
    backdrop-filter: blur(20px);
}

.modal-content {
 
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    text-align: center;
    background-color: transparent;
    backdrop-filter: blur(18px);
}

.modal-header {
    font-size: 24px;
    margin-bottom: 20px;
    color: #000;
}

.modal-footer {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.modal-footer button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-footer .confirm {
    background-color: #384B70;
    color: red;
}

.modal-footer .cancel {
    background-color: #f44336;
    color: red;
}

.modal-footer .confirm:hover {
    background-color: #45a049;
}

.modal-footer .cancel:hover {
    background-color: #f21b1b;
}

#checkout-message {
    color: red;
    text-align: center;
    font-size: 18px;
}

/* Form Elements in Modal */
#checkout-form input, #checkout-form textarea {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

#coupon {
    background-color: #eee;
}

/* Media Queries */
@media (max-width: 768px) {
    .cart-header {
        display: none;
    }

    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .cart-item div {
        text-align: left;
        padding: 10px 0;
    }

    .cart-item img {
        margin-bottom: 10px;
    }

    #cart-items {
        width: 95%;
        padding: 10px;
    }
}

@media (max-width: 480px) {
    header, footer {
        padding: 10px 0;
    }

    main {
        padding: 60px 10px 20px;
    }

    .banner img {
        max-height: 200px;
    }

    h2 {
        font-size: 24px;
    }

    #checkout-btn {
        width: 90%;
        padding: 10px;
        font-size: 16px;
    }
}



</style>
<main>
  <section class="banner">
    <img src="cart.jpg" alt="Promotional Banner">
  </section>


  <h2> 🛒 Your Cart</h2>

    <?php if (!$user_id): ?>
        <p id="login-message"> 🚨Log in or Sign up First to see Your Cart🚨</p>
    <?php endif; ?>

    <div id="cart-items">
        <div class="cart-header">
            <div class="item-name">Item</div>
            <div>Size-M</div>
            <div>Size-L</div>
            <div>Size-XL</div>
            <div>Size-XXL</ div>
            <div>Price</div>
            <div>Remove</div>
        </div>

        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $product): ?>
            <div class="cart-item">
                <div class="item-name"><?php echo htmlspecialchars($product['name']); ?></div>
                <div><?php echo htmlspecialchars($product['size_m'] ?? 0); ?></div>
                <div><?php echo htmlspecialchars($product['size_l'] ?? 0); ?></div>
                <div><?php echo htmlspecialchars($product['size_xl'] ?? 0); ?></div>
                <div><?php echo htmlspecialchars($product['size_xxl'] ?? 0); ?></div>
                <div><?php echo htmlspecialchars($product['price'] ?? 0); ?>৳</div>
                <div><button onclick="removeFromCart(<?php echo $product['id']; ?>)">Remove</button></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No items in your cart.</p>
        <?php endif; ?>

    

    <div class="subtotal">
    <h3>Subtotal:</h3>
    <p><span id="subtotal-value"><?php echo calculateSubtotal($cart); ?></span>৳</p>
</div>
</div>

<div id="coupon-section">
    <h3>Apply Coupon (10% Discount)</h3>
    <div class="coupon-input">
        <input type="text" id="coupon" placeholder="Enter coupon code">
        <button type="button" onclick="applyCoupon()">Apply</button>
    </div>
</div>

<div id="delivery-options">
    <h3>Delivery Options</h3>
    <div class="delivery-options-container">
        <label>
            <input type="radio" name="delivery-option" value="pickup" onclick="updateDeliveryCost(50)">
            <span>Pick up from Chashara, Narayanganj / R. P. Shaha University (50৳)</span>
        </label>
        <label>
            <input type="radio" name="delivery-option" value="home-delivery" onclick="updateDeliveryCost(100)">
            <span>Home Delivery (100৳)</span>
        </label>
    </div>
</div>

<div id="total-cost">
    <h3>Total Cost:</h3>
    <p><span id="total-cost-value"><?php echo calculateSubtotal($cart); ?></span>৳</p>
</div>

<button id="checkout-btn" onclick="showCheckoutModal()">Checkout</button>

    <!-- Checkout Modal -->
    <div id="checkout-modal" class="modal">
        <div class="modal-content">
            <h2>Checkout</h2>
            <div id="checkout-message"> </div> <!-- Message will appear here if not logged in -->
            
            <form id="checkout-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $_SESSION['user_name'] ?? ''; ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['user_phone'] ?? ''; ?>" required>

                <label for="email">Email (optional):</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['user_email'] ?? ''; ?>">

                <label for="address">Delivery Address:</ label>
                <textarea id="address" name="address" required><?php echo $_SESSION['user_address'] ?? ''; ?></textarea>

                <button type="button" onclick="editDetails()">Edit Details</button>

                <p id="total-cost">Total Cost: <span id="total-cost-value"><?php echo calculateSubtotal($cart); ?></span>৳</p>

                <p>We will send you a confirmation message on your phone number.</p>
                <p>Will you proceed?</p>

                <button type="button" onclick="submitOrder()">Yes</button>
                <button type="button" onclick="closeModal()">No</button>
            </form>
        </div>
    </div>

    <p>⚠️Don't forget to read the terms and conditions before checkout⚠️</p>
</main>


<script>
  let subtotal = <?php echo calculateSubtotal($cart); ?>;
  let deliveryCost = 0;
  let discountedTotalCost = subtotal;

  function applyCoupon() {
  const couponCode = document.getElementById('coupon').value;
  const subtotal = <?php echo calculateSubtotal($cart); ?>;
  fetch('apply_coupon.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      couponCode: couponCode,
      subtotal: subtotal
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      discountedTotalCost = data.discountedSubtotal;
      alert('Coupon applied successfully! 10% discount');
    } else {
      discountedTotalCost = subtotal;
      alert('Invalid coupon code');
    }
    updateTotalCost();
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

function updateDeliveryCost(cost) {
  const deliveryOption = document.querySelector('input[name="delivery-option"]:checked').value;
  const subtotal = <?php echo calculateSubtotal($cart); ?>;
  fetch('update_delivery_cost.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      deliveryOption: deliveryOption,
      subtotal: subtotal
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      deliveryCost = cost;
      updateTotalCost();
    } else {
      alert('Error updating delivery cost');
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

  function updateTotalCost() {
    const totalCost = discountedTotalCost + deliveryCost;
    document.getElementById('total-cost-value').innerText = totalCost.toFixed(2);
  }

  function showCheckoutModal() {
    const modal = document.getElementById('checkout-modal');
    const loginMessage = document.getElementById('login-message');
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    
    if (isLoggedIn) {
        modal.style.display = 'block';
        document.getElementById('checkout-message').innerHTML = '';
        document.getElementById('total-cost-value').innerText = subtotal.toFixed(2);
        loginMessage.style.display = 'none';
    } else {
        document.getElementById('checkout-message').innerHTML = "Please log in first to proceed to checkout.";
        modal.style.display = 'none';
        loginMessage.style.display = 'block';
    }
  }

  function closeModal() {
      document.getElementById('checkout-modal').style.display = 'none';
  }

  function editDetails() {
      document.getElementById('name').removeAttribute('readonly');
      document.getElementById('phone').removeAttribute('readonly');
      document.getElementById('email').removeAttribute('readonly');
      document.getElementById('address').removeAttribute('readonly');
  }

  function submitOrder() {
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;

    if (!name || !phone || !address) {
        alert('Please fill out all required fields.');
        return;
    }

    // Validate data
    if (!validateName(name) || !validatePhone(phone) || !validateEmail(email) || !validateAddress(address)) {
        alert('Invalid data. Please check your input.');
        return;
    }

    // Send data to the server
    const data = {
        name,
        phone,
        email,
        address,
        totalCost: discountedTotalCost
    };

    fetch('submit_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order placed successfully!');
            closeModal();
        } else {
            alert('Failed to place order.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error placing order.');
    });
}

function validateName(name) {
    // Validate name
    return true;
}

function validatePhone(phone) {
    // Validate phone
    return true;
}

function validateEmail(email) {
    // Validate email
    return true;
}

function validateAddress(address) {
    // Validate address
    return true;
}

  function removeFromCart(productId) {
      fetch(`remove_from_cart.php?id=${productId}`)
          .then(() => {
              alert('Item removed from cart');
              window.location.reload();
          })
          .catch(error => {
              console.error('Error removing item:', error);
          });
  }
</script>

<?php
include('footer.php');
?>