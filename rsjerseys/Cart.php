<?php
session_start();
include('header.php');
include('database_connection.php'); // Include your database connection file

// Initialize the cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize variables
$deliveryCost = 0;
$discount = 0;
$cart = $_SESSION['cart']; // Now the session cart is always initialized
$userId = $_SESSION['user_id'] ?? null;

// You may want to load the cart from the database for logged-in users
if ($userId) {
    // Fetch cart data from the database for the logged-in user
    // Example: $cart = fetch_cart_from_database($userId);
    // $_SESSION['cart'] = $cart; // Sync with session
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


    footer {
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 20px;
      text-align: center;
      margin-top: 30px;
      border-top: 3px solid #ffcd00;
      width: 97.4%;
    }

    footer p {
      margin: 5px 0;
    }
    main {
      padding: 30px 20px 30px;
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
      margin-bottom: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .banner img:hover {
      transform: scale(1.05);
    }

    h2 {
      font-size: 36px;
      color: #873e23;
      margin-bottom: 20px;
    }

    #cart-items {
      background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      margin: 50px auto 20px;
      color: #000;
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
  
  border-radius: 10px;
  
  background: rgba(255, 255, 255, 0.2);
  width: 550px;
  padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      margin: 10px auto 20px;
}

.coupon-input {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  margin-right : 10px;
}

.coupon-input input {
  width: 40%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  color: #000000;
}

.coupon-input button {
  width: 20%;
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

#coupon-message {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

#delivery-options {
  background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      width: 550px;
      margin: 10px auto 10px;
      COLOR : BLACK;
}

.delivery-options-container {
  display: flex;
  flex-direction: column;
}

.delivery-options-container label {
  margin-bottom: 10px;
}

#total-cost {
  margin-bottom: 20px;
  background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      width: 550px;
      margin: 10px auto 10px;
      COLOR : BLACK;
}

#total-cost-value {
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
 
   
text-align : center;
  background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      width: 600px;
      margin: 10px auto 10px;
      COLOR : BLACK;
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
    background-color: green;
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
    /* Hide cart header for small screens */
    .cart-header {
        display: none;
    }

    /* Stack navigation items vertically */
    nav ul {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    /* Make cart items stack vertically */
    .cart-item {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    /* Adjust cart item content alignment */
    .cart-item div {
        text-align: left;
        padding: 10px 0;
        width: 100%;
    }

    /* Ensure product image scales well on small screens */
    .cart-item img {
        margin-bottom: 10px;
        max-width: 100px;
    }

    /* Adjust cart container for smaller widths */
    #cart-items {
        width: 95%;
        padding: 15px;
    }

    /* Coupon, Delivery, and Total sections adjustments */
    #coupon-section, #delivery-options, #total-cost {
        width: 95%;
        padding: 15px;
    }

    /* Adjust modal content for smaller screens */
    .modal-content {
        width: 95%;
    }
}

@media (max-width: 480px) {
    /* Reduce padding in header and footer */
    header, footer {
        padding: 10px 0;
    }

    /* Adjust main content padding */
    main {
        padding: 60px 10px 20px;
    }

    /* Adjust banner image size */
    .banner img {
        max-height: 200px;
        max-width: 80%;
        margin: 0 auto;
    }

    /* Reduce heading size */
    h2 {
        font-size: 24px;
    }

    /* Adjust checkout button styling */
    #checkout-btn {
        width: 90%;
        padding: 10px;
        font-size: 16px;
    }

    /* Stack navigation vertically on very small screens */
    nav ul {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    /* Further reduce image size */
    .banner img {
        max-width: 80%;
    }

    /* Adjust cart items and modal */
    .cart-item img {
        max-width: 80px;
    }

    /* Ensure modal content is fully visible */
    .modal-content {
        width: 90%;
        margin: 10px auto;
    }

    /* Coupon, Delivery, and Total sections on very small screens */
    #coupon-section, #delivery-options, #total-cost {
        width: 100%;
        padding: 10px;
    }
}







</style>
<main>
    <section class="banner">
        <img src="cart.jpg" alt="Promotional Banner">
    </section>

    <h2> 🛒 Your Cart</h2>

    <div id="cart-items">
        <div class="cart-header">
            <div class="item-name">Item</div>
            <div>Size-M</div>
            <div>Size-L</div>
            <div>Size-XL</div>
            <div>Size-XXL</div>
            <div>Total Quantity</div>
            <div>Price</div>
            <div>Remove</div>
        </div>

        <div id="cart-items-container"></div>

        <div class="subtotal">
            <h3>Subtotal:</h3>
            <p><span id="subtotal-value">0</span>৳</p>
        </div>
    </div>

    <button id="checkout-btn" onclick="showCheckoutModal()">Checkout</button>

    <!-- Checkout Modal -->
    <div id="checkout-modal" class="modal">
        <div class="modal-content">
            <h2>Checkout</h2>
            <div id="checkout-message"></div>

            <form id="checkout-form" method="post" action="process_checkout.php">
                <!-- CSRF token for security 
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                -->

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="email">Email (optional):</label>
                <input type="email" id="email" name="email">

                <label for="address">Delivery Address:</label>
                <textarea id="address" name="address" required></textarea>

                <label for="district">District & Police Station(থানা) :</label>
                <textarea id="district" name="district" required></textarea>

                <!-- Hidden input to store the applied coupon code -->
                <input type="hidden" name="coupon" id="coupon-code" value="">

                <div id="coupon-section">
                    <h3>Apply Coupon (10% Discount)</h3>
                    <div class="coupon-input">
                        <input type="text" id="coupon" placeholder="Enter coupon code">
                        <button type="button" id="apply-coupon-btn">Apply</button>
                    </div>
                    <p id="coupon-message"></p>
                </div>

                <div id="delivery-options">
                    <h3>Delivery Options</h3>
                    <div class="delivery-options-container">
                    <label>
    <input type="radio" name="delivery-option" value="50" data-cost="50">
    Pick up from Chashara, Narayanganj / R. P. Shaha University (50৳)
</label>
<label>
    <input type="radio" name="delivery-option" value="100" data-cost="100">
    Home Delivery (100৳)
</label>
                    </div>
                </div>

                <div id="total-cost">
                    <h3>Total Cost:</h3>
                    <p><span id="total-cost-value">0</span>৳</p>
                    <p>If the Total Cost displays "NaN৳", please select the delivery option again. We are working to fix this bug soon 🕷️</p>
                </div>

                <button type="submit">Place Order</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <p>⚠️ Don't forget to read the terms and conditions before checkout ⚠️</p>
</main>
<script>
    let subtotal = 0; // Global variable to store subtotal
    let deliveryCost = 0; // Global variable to store delivery cost
    let discount = 0; // Global variable for discount (if coupon applied)
    const validCoupon = 'RS10JERSEYS'; // The valid coupon code for 10% off
    let updatingTotalCost = false; // Flag to prevent multiple updates

    // Function to display cart items
    function displayCartItems() {
        const cartItemsContainer = document.getElementById('cart-items-container');
        if (!cartItemsContainer) return;

        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItemsContainer.innerHTML = '';

        subtotal = 0; // Reset subtotal

        cart.forEach((item, index) => {
            const totalItemQuantity = calculateTotalItemQuantity(item);
            const totalItemPrice = calculateItemTotal(item);
            subtotal += totalItemPrice;

            console.log(`Item ${index} subtotal: ${totalItemPrice}`);

            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.innerHTML = `
                <div class="item-name"><img src="${item.image}" alt="${item.name}"> ${item.name}</div>
                ${generateQuantityControls(item, index)}
                <div>${totalItemQuantity}</div>
                <div>${totalItemPrice.toFixed(2)}৳</div>
                <div><button onclick="removeFromCart(${index})">Remove</button></div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });

        console.log(`Total subtotal: ${subtotal}`);
        document.getElementById('subtotal-value').innerText = subtotal.toFixed(2);
        updateTotalCost(); // Recalculate total cost after updating subtotal
    }

    // Function to update total cost
    function updateTotalCost() {
        if (updatingTotalCost) return;
        updatingTotalCost = true;

        const totalCostElement = document.getElementById('total-cost-value');

        // Ensure subtotal is a valid number
        const currentSubtotal = parseFloat(subtotal) || 0;

        // Get delivery cost and ensure it's a valid number
        const deliveryOption = document.querySelector('input[name="delivery-option"]:checked');
        deliveryCost = deliveryOption ? parseFloat(deliveryOption.value) : 0;
        deliveryCost = isNaN(deliveryCost) ? 0 : deliveryCost;

        // Calculate total cost with discount
        const totalCost = (currentSubtotal - discount) + deliveryCost;

        if (totalCostElement) {
            totalCostElement.innerText = totalCost.toFixed(2);
        }

        updatingTotalCost = false;
    }

    // Function to calculate subtotal
    function calculateSubtotal() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        return cart.reduce((total, item) => total + calculateItemTotal(item), 0);
    }

    // Function to remove an item from the cart
    function removeFromCart(index) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1); // Remove the item at the given index
        localStorage.setItem('cart', JSON.stringify(cart)); // Update local storage
        displayCartItems(); // Refresh the cart items display
    }

    // Display cart items when the page loads
    document.addEventListener('DOMContentLoaded', displayCartItems);

    // Helper function to calculate the total quantity of an item
    function calculateTotalItemQuantity(item) {
        return (parseInt(item.sizeMQuantity) || 0) + 
               (parseInt(item.sizeLQuantity) || 0) + 
               (parseInt(item.sizeXLQuantity) || 0) + 
               (parseInt(item.sizeXXLQuantity) || 0);
    }

    // Helper function to calculate the total price of an item
    function calculateItemTotal(item) {
        const sizeMTotal = (parseFloat(item.sizeMQuantity) * parseFloat(item.sizeMPrice)) || 0;
        const sizeLTotal = (parseFloat(item.sizeLQuantity) * parseFloat(item.sizeLPrice)) || 0;
        const sizeXLTotal = (parseFloat(item.sizeXLQuantity) * parseFloat(item.sizeXLPrice)) || 0;
        const sizeXXLTotal = (parseFloat(item.sizeXXLQuantity) * parseFloat(item.sizeXXLPrice)) || 0;
        return sizeMTotal + sizeLTotal + sizeXLTotal + sizeXXLTotal;
    }

// Helper function to generate quantity controls for different sizes
function generateQuantityControls(item, index) {
    return `
        <div class="quantity-controls">
            <span>M</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'M', -1)">-</button>
            <span>${item.sizeMQuantity}</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'M', 1)">+</button>
        </div>
        <div class="quantity-controls">
            <span>L</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'L', -1)">-</button>
            <span>${item.sizeLQuantity}</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'L', 1)">+</button>
        </div>
        <div class="quantity-controls">
            <span>XL</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'XL', -1)">-</button>
            <span>${item.sizeXLQuantity}</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'XL', 1)">+</button>
        </div>
        <div class="quantity-controls">
            <span>XXL</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'XXL', -1)">-</button>
            <span>${item.sizeXXLQuantity}</span>
            <button type="button" onclick="changeItemQuantity(${index}, 'XXL', 1)">+</button>
        </div>
    `;
}
    // Function to change item quantity
    function changeItemQuantity(index, size, change) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let item = cart[index];

        if (!item) return;

        if (size === 'M') item.sizeMQuantity = Math.max(0, (parseInt(item.sizeMQuantity) || 0) + change);
        if (size === 'L') item.sizeLQuantity = Math.max(0, (parseInt(item.sizeLQuantity) || 0) + change);
        if (size === 'XL') item.sizeXLQuantity = Math.max(0, (parseInt(item.sizeXLQuantity) || 0) + change);
        if (size === 'XXL') item.sizeXXLQuantity = Math.max(0, (parseInt(item.sizeXXLQuantity) || 0) + change);

        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems();
    }

    function showCheckoutModal() {
        const modal = document.getElementById('checkout-modal');
        const checkoutMessage = document.getElementById('checkout-message');
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        if (!isLoggedIn) {
            alert('Please log in first.');
            return;
        }

        checkoutMessage.style.display = 'none'; // Hide any previous messages
        populateUserDetails(); // Populate user details into the modal
        updateTotalCost(); // Ensure the total cost is updated in the modal
        modal.style.display = 'block'; // Show modal if logged in
    }

    function populateUserDetails() {
        const userId = <?php echo json_encode($userId); ?>;
        if (!userId) return;

        // Example AJAX call to get user details
        fetch(`get_user_details.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('address').value = data.address || '';
                document.getElementById('district').value = data.district || '';
            })
            .catch(error => console.error('Error fetching user details:', error));
    }

    function closeModal() {
        const modal = document.getElementById('checkout-modal');
        modal.style.display = 'none'; // Hide modal
    }

    // Function to apply coupon
    function applyCoupon() {
        const couponInput = document.getElementById('coupon');
        const couponMessage = document.getElementById('coupon-message');
        const couponCode = couponInput.value.trim().toUpperCase();

        if (couponCode === '') {
            couponMessage.innerText = 'Please enter a coupon code.';
            couponMessage.style.color = 'red';
            return;
        }

        if (couponCode === validCoupon) {
            discount = subtotal * 0.10; // 10% discount
            document.getElementById('coupon-code').value = couponCode; // Set hidden input
            couponMessage.innerText = 'Coupon applied successfully! 10% discount has been added.';
            couponMessage.style.color = 'green';
        } else {
            discount = 0;
            document.getElementById('coupon-code').value = ''; // Clear hidden input
            couponMessage.innerText = 'Invalid coupon code.';
            couponMessage.style.color = 'red';
        }

        // Update subtotal display to reflect discount
        const discountedSubtotal = subtotal - discount;
        document.getElementById('subtotal-value').innerText = discountedSubtotal.toFixed(2);

        // Recalculate and update total cost
        updateTotalCost();
    }

    // Event listener for the coupon apply button
    document.getElementById('apply-coupon-btn').addEventListener('click', applyCoupon);

    // Event listeners for delivery option changes
    document.querySelectorAll('input[name="delivery-option"]').forEach((radio) => {
        radio.addEventListener('change', updateTotalCost);
    });

    // Handle form submission
    // Handle form submission
document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    formData.append('cart', JSON.stringify(cart)); // Add cart data

    fetch('process_checkout.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Log the server response
        const checkoutMessage = document.getElementById('checkout-message'); // Get the message element
        if (data.status === 'success') {
            alert(data.message);
            localStorage.removeItem('cart'); // Clear the cart from localStorage
            displayCartItems(); // Refresh cart display
            closeModal(); // Close the checkout modal
        } else {
            checkoutMessage.innerText = data.message; // Show error message
            checkoutMessage.style.color = 'red';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const checkoutMessage = document.getElementById('checkout-message');
        checkoutMessage.innerText = 'An error occurred. Please try again.'; // Show error message
        checkoutMessage.style.color = 'red';
    });
});


</script>

<?php
include('footer.php');
?>