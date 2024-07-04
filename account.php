<?php
session_start();
include "connect.php";

$errorMsg = ""; 

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $password = $_POST['password'];
    $account = $_POST['account-number'];
    
    $_SESSION["form_data"] = $_POST;
    
    if(($name && $email && $password && $account) == ""){
        $errorMsg = '<h3 style="color: white;">Kindly fill out the form</h3>';  
    } else {
        $selectEmail = mysqli_query($conn, "SELECT * FROM `via` WHERE `account` = '$account'");
        $resultEmail = mysqli_num_rows($selectEmail);
        
        if($resultEmail > 0){
            $errorMsg = '<h6 style="color: red; margin-top:10px;">Email already exists</h6>';
        } else {
            $selectAccount = mysqli_query($conn, "SELECT * FROM `via` WHERE `account` = '$account'");
            $resultAccount = mysqli_num_rows($selectAccount);
            
            if($resultAccount > 0){
                $errorMsg = '<h6 style="color: red; margin-top:10px;">Account already exists</h6>';
            } else {
                if(mysqli_query($conn, "INSERT INTO `via`(`name`, `email`, `password`, `account`) VALUES ('$name','$email','$password', '$account')")){
                    header("location: login.php");
                    exit(); 
                } else {
                    $errorMsg = '<h6 style="color: red; margin-top:10px;">Error inserting record</h6>';
                }
            }
        }
        
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via_Bankz Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="account.css ">
</head>
<style>
    .avatar{
    width: 80px;
    }
    form h2{
        font-size: 2.9rem;
        font-weight: 500;
        text-transform: uppercase;
        margin: 0px 0;
        color: #333;
    }
</style>
<body>
    <div class="all">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        width="498.23px" height="644px" viewBox="0 0 620.23 789.73"
        style="overflow:visible;enable-background:new 0 0 498.23 789.73;" xml:space="preserve">
            <style type="text/css">
                .st0{fill:#54baac;stroke-miterlimit:10;}
            </style>
            <defs>
            </defs>
            <path class="st0" d="M0.53,4.53c9.39,40.84,31.33,93.6,63.26,149.57c63.83,111.86,158.8,176.21,184.35,193.04
                c67.99,44.8,100.84,45.86,150.43,100c34.18,37.31,53.95,75.42,64.35,99.13c28.33,64.62,31.36,123.42,33.91,173.04
                c1.48,28.76,0.88,52.85,0,69.91H5.53L0.53,4.53z"/>
        </svg>
        <div class="container">
            <div class="img">
                <img src="./images/undraw_profile_data_re_v81r.svg" alt="">
            </div>
            <div class="login-container">
                <form id="account-form" action="" method="post" enctype="multipart/form-data"> 
                    <div class="koo">
                        <img class="avatar" src="./images/undraw_pic_profile_re_7g2h (1).svg" alt="">
                        <h2>Welcome</h2>
                    </div>
                    <div class="ada">
                         <label for="account-number">Your account number</label>
                        <input type="text" id="account-number" name="account-number" placeholder="Wallet address" >
                    </div>
                    <div class="ada">
                        <label for="name">Your name</label>
                        <input type="text" id="name" name="name" required placeholder="John Doe">
                    </div>
                    <div class="ada">
                        <label for="email">Your email</label>
                        <input type="email" id="email" name="email" required placeholder="johndoe@gmail.com">
                    </div>
                    <div class="ada">
                        <label for="email">Password</label>
                        <input type="password" id="password" name="password" required placeholder="*********">
                    </div>
                    <?php echo $errorMsg; ?>
                    <div class="d-flex bab">
                        <h6>Already have an account? </h6>
                        <a href="login.php">Login</a>
                    </div>
                    <button type="submit" name="submit" id="login-btn" class="btn mt-5">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const walletAddress = localStorage.getItem('walletAddress');
            if (walletAddress) {
                document.getElementById('account-number').value = walletAddress;
            } else {
                alert("Wallet address not found. Please connect wallet first.");
                window.location.href = "index.html"; 
            }

            const loginBtn = document.getElementById('login-btn');
            loginBtn.addEventListener('click', () => {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                window.location.href = "dashboard.html";
            });
        });
    </script>
</body>
</html>

