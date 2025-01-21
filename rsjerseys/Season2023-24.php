<?php include('header.php'); 
include 'database_connection.php';

$sql1 = "SELECT * FROM season23_24 where section='RMA'";
$result1 = $conn->query($sql1);

$sql3 = "SELECT * FROM season23_24 where section='barca'";
$result3 = $conn->query($sql3);

$sql5 = "SELECT * FROM season23_24 where section='manu'";
$result5 = $conn->query($sql5);

$sql4 = "SELECT * FROM season23_24 where section='bayern'";
$result4 = $conn->query($sql4);

$sql2 = "SELECT * FROM season23_24 where section='mancity'";
$result2 = $conn->query($sql2);


?>
<main>
        <section class="banner">
            <img src="season23-24.png" alt="Promotional Banner">
          </section>


          <h2>Real Madrid's Jersey</h2>

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
                  echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';

                }
                else{
                  echo '<p> *' . $row['stock_status'] .'*</p>';         
                echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';
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

          <h2>Manchester-City's Jersey</h2>

          <section class="products">



<?php
if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
      echo '<div class="product" id="product' . $row['id'] . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">';
      echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" onclick="showImage(\'' . $row['image'] . '\')">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['price'] . '৳</p>';
        if($row['stock_status'] == 'OUT OF STOCK'){
          echo '<p> *' . $row['stock_status'] .'*</p>';
          echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';

        }
        else{
          echo '<p> *' . $row['stock_status'] .'*</p>';         
        echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';
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
         
          <h2>FC Barcelona's Jersey</h2>
          <section class="products">



<?php
if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
      echo '<div class="product" id="product' . $row['id'] . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">';
      echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" onclick="showImage(\'' . $row['image'] . '\')">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['price'] . '৳</p>';
        if($row['stock_status'] == 'OUT OF STOCK'){
          echo '<p> *' . $row['stock_status'] .'*</p>';
          echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';

        }
        else{
          echo '<p> *' . $row['stock_status'] .'*</p>';         
        echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';
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
    

          <h2>Manchester United's Jersey</h2>
        
          <section class="products">



<?php
if ($result5->num_rows > 0) {
    while($row = $result5->fetch_assoc()) {
      echo '<div class="product" id="product' . $row['id'] . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">';
      echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" onclick="showImage(\'' . $row['image'] . '\')">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['price'] . '৳</p>';
        if($row['stock_status'] == 'OUT OF STOCK'){
          echo '<p> *' . $row['stock_status'] .'*</p>';
          echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';

        }
        else{
          echo '<p> *' . $row['stock_status'] .'*</p>';         
        echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';
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


          <h2>FC Bayern's Jersey</h2>

         
          <section class="products">



<?php
if ($result4->num_rows > 0) {
    while($row = $result4->fetch_assoc()) {
      echo '<div class="product" id="product' . $row['id'] . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '" data-image="' . $row['image'] . '">';
      echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" onclick="showImage(\'' . $row['image'] . '\')">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['price'] . '৳</p>';
        if($row['stock_status'] == 'OUT OF STOCK'){
          echo '<p> *' . $row['stock_status'] .'*</p>';
          echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';

        }
        else{
          echo '<p> *' . $row['stock_status'] .'*</p>';         
        echo '<button class="details-btn" onclick="openDetailsPage(\'productdetails3.php?id=' . $row['id'] . '\')">Details </button>';
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
          
      </main>
      <div id="message-container" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; display: none; z-index: 1000;">
    Item added to cart!
  </div>

<?php include('footer.php'); ?>
