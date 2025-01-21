<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}
?>
<?php include('header.php'); ?>
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
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
  }


  .wrapper {
    width: 80%;
    max-width: 450px;
    margin: 120px auto;
    padding: 30px 35px;
    text-align: center;
    background: transparent;
    border-radius: 10px;
    box-shadow: 0 0 13px rgba(228, 224, 224, 0.918);
    backdrop-filter: blur(15px);
  }

  .wrapper img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto 20px auto;
  }

  .wrapper h1 {
    font-size: 36px;
    margin-bottom: 20px;
  }

  .login-btn,
  .signup-btn {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .login-btn {
    background-color: #640bad;
    color: #fff;
  }

  .signup-btn {
    background-color: #28a745;
    color: #fff;
  }

  .login-btn:hover,
  .signup-btn:hover {
    background-color: #0056b3;
  }
</style>

<div class="wrapper">
  <img src="banneraccount.png" alt="banner">
  <br>
  <div class="options">
    <a href="signup.html" class="signup-btn">Sign Up</a>
    <a href="login.html" class="login-btn">Log In</a>
  </div>
</div>

<?php include('footer.php'); ?>
