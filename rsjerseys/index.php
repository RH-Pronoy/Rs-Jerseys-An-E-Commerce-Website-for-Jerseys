<?php
include "header.php";
?>

<?php
include 'database_connection.php';

$sql1 = "SELECT * FROM arrivals";
$result1 = $conn->query($sql1);

?>


<section class="banner">
  <img src="bannerhome.png" alt="Promotional Banner">
</section>


<h2>* New Arrivals *</h2>

<section class="products">



<?php
        if ($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
              echo '<div class="product" id="product' . $row['id'] . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">';
              echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" onclick="showImage(\'' . $row['image'] . '\')">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['price'] . '৳</p>';
                if($row['stock_status'] == 'OUT OF STOCK'){
                  echo '<p> *' . $row['stock_status'] .'*</p>';
                  echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails1.php?id=' . $row['id'] . '\')">Details </button>';

                }
                else{
                  echo '<p> *' . $row['stock_status'] .'*</p>';         
                echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails1.php?id=' . $row['id'] . '\')">Details </button>';
                echo ' ';
                echo '<button class="add-to-cart-btn" onclick="addToCart(\'product' . $row['id'] . '\')">Add to Cart</button>';
                }
                echo '</div>';
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
</section>

<div id="message-container" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; display: none; z-index: 1000;">
    Item added to cart!
  </div>


<?php
include "footer.php";
?>