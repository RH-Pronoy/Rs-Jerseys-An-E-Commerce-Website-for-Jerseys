// Function to open details page
function openDetailsPage(pageUrl) {
  window.location.href = pageUrl;
}

// Function to show image
function showImage(imageSrc) {
  const enlargedImage = document.createElement('div');
  enlargedImage.innerHTML = `<img src="${imageSrc}" style="max-width: 100%; max-height: 100vh; object-fit: contain;">`;
  enlargedImage.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); display: flex; justify-content: center; align-items: center; z-index: 999;';
  enlargedImage.onclick = function() {
    enlargedImage.parentElement.removeChild(enlargedImage);
  };
  document.body.appendChild(enlargedImage);
}

// Function to add item to cart
function addToCart(productId) {
  const product = document.getElementById(productId);
  const productName = product.getAttribute('data-name');
  const productPrice = product.getAttribute('data-price');
  const productImage = product.getAttribute('data-image');

  // Check if product is already in cart
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  let existingItem = cart.find(item => item.id === productId);

  if (existingItem) {
    // Update quantity of existing item
    existingItem.sizeMQuantity++;  // Increment the quantity for size M by default
  } else {
    // Add new item to cart
    cart.push({
      id: productId,
      name: productName,
      price: parseFloat(productPrice),
      image: productImage,
      sizeMQuantity: 1,
      sizeLQuantity: 0,
      sizeXLQuantity: 0,
      sizeXXLQuantity: 0
    });
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  showAddedMessage();
  displayCartItems();
}


// Function to show "Item added" message
function showAddedMessage() {
  alert('Item added to cart!');
}

// Initial setup to display cart items on page load
window.onload = function() {
  displayCartItems();
};
