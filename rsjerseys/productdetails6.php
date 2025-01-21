<?php
session_start();
include('header2.php');
include 'database_connection.php';

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database
    $sql = "SELECT * FROM retro WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <div class="container">
            <h1><?php echo htmlspecialchars($row['name']); ?></h1>
            <div class="product-info">
                <div class="image-gallery">
                    <img class="product-image" src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" onclick="showImage('<?php echo htmlspecialchars($row['image']); ?>')">
                    <div class="gallery-thumbnails">
                        <img src="<?php echo htmlspecialchars($row['image2']); ?>" alt="Image 1" onclick="showImage('<?php echo htmlspecialchars($row['image2']); ?>')">
                        <img src="<?php echo htmlspecialchars($row['image3']); ?>" alt="Image 2" onclick="showImage('<?php echo htmlspecialchars($row['image3']); ?>')">
                    </div>
                </div>
                <div class="product-details">
                    <h2>Product Details</h2>
                    <ul>
                        <li><?php echo htmlspecialchars($row['feature1']); ?></li>
                        <li><?php echo htmlspecialchars($row['feature2']); ?></li>
                        <li><?php echo htmlspecialchars($row['feature3']); ?></li>
                        <li><?php echo htmlspecialchars($row['feature4']); ?></li>
                        <li><?php echo htmlspecialchars($row['fabric']); ?></li>
                    </ul>
                    <h2>Available Size:</h2>
                    <p><?php echo htmlspecialchars($row['sizes']); ?></p>
                    <h2>Size Chart :</h2>
                    <p><?php echo htmlspecialchars($row['size_chart']); ?></p>
                    <h2>Pricing and Availability</h2>
                    <p>Price: <?php echo htmlspecialchars($row['price']); ?>৳</p>

                    <!-- Add hidden div with product data -->
                    <div id="product<?php echo $row['id']; ?>" 
                        data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                        data-price="<?php echo htmlspecialchars($row['price']); ?>" 
                        data-image="<?php echo htmlspecialchars($row['image']); ?>">
                    </div>

                    <?php
                    if($row['stock_status'] == 'OUT OF STOCK'){
                        echo '<p> *' . $row['stock_status'] .'*</p>';
                    } else {
                        echo '<p> *' . $row['stock_status'] .'*</p>';         
                        echo '<button class="add-to-cart-btn" onclick="addToCart(\'product' . $row['id'] . '\')">Add to Cart</button>';
                    }
                    ?>
                </div>
            </div>
            <div id="message-container" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; display: none; z-index: 1000;">
    Item added to cart!
  </div>


            <!-- Review Section Start -->
            <h2>Reviews:</h2>
            <?php
            $review_sql = "SELECT * FROM reviews WHERE product_id = ? ORDER BY review_date DESC";
            $review_stmt = $conn->prepare($review_sql);
            $review_stmt->bind_param("i", $product_id);
            $review_stmt->execute();
            $review_result = $review_stmt->get_result();

            if ($review_result->num_rows > 0) {
                while ($review = $review_result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<h3>" . htmlspecialchars($review['user_name']) . " - " . htmlspecialchars($review['rating']) . "/5</h3>";
                    echo "<p>" . htmlspecialchars($review['review_text']) . "</p>";
                    
                    echo "<p><em>Reviewed on " . htmlspecialchars($review['review_date']) . "</em></p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet. Be the first to review this product!</p>";
            }
            ?>
            
            <div class="review-section">
                <h2>Leave a Review</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="submit_review.php" method="post" enctype="multipart/form-data" id="reviewForm">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                        <label for="rating">Rating:</label>
                        <select name="rating" id="rating" required>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>

                        <label for="review_text">Review:</label>
                        <textarea name="review_text" id="review_text" required></textarea>
                        <button type="submit">Submit Review</button>
                    </form>
                <?php else: ?>
                    <p>You need to <a href='YourAccount.php'>log in</a> to leave a review.</p>
                <?php endif; ?>
            </div>
            <!-- Review Section End -->
        </div>
<?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}

include('footer.php');
?>

<script>
// JavaScript function for adding products to the cart


// Function to show the message after adding to cart
function showMessage(message) {
    const messageContainer = document.getElementById('message-container');
    messageContainer.textContent = message;
    messageContainer.style.display = 'block';

    // Hide the message after 3 seconds
    setTimeout(() => {
        messageContainer.style.display = 'none';
    }, 3000);
}


// Review submission with fetch API
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);
    
    fetch('submit_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message); // Show success message
            location.reload(); // Reload the page to display the new review
        } else {
            alert(data.message); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the review.');
    });
});
</script>
