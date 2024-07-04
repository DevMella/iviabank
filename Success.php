<?php
    session_start();
    include "connect.php";

    $account = $_GET['success'];
    $select = "SELECT * FROM transfers WHERE account = '$account' ORDER BY `id` DESC";
    $signin_details = mysqli_query($conn, $select);
    $signin =  mysqli_fetch_assoc($signin_details);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via_Bankz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="trans.css">
</head>
<body>
    <style>
        .bax{
            width: 200px;
            height: 150px;
            font-size: 35px;
            background-color: gainsboro;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #54baac;
            flex-direction: column !important;
        }
        .conn a{
            text-decoration: none;
        }
    </style>
   <div class="all">
        <div class="don">
            <a href="dashboard.php" class="mt-4"><h6>Done</h6></a>
        </div>  
        <div class="conn">
            <div class="cir">
                <i class="fa-solid fa-check"></i>
            </div>
            <h4>Transfer successful</h4>
            <h3 class="amount"> ₦<?php echo $signin['amount']?></h3>
            <h6 class="text-center">The recipient account is to be credited within 5 minutes, subject to notification by the bank.</h6>
            <a href="receipt.php" class="mt-4">
                <div class="bax">
                    <i class="fa-solid fa-download"></i>
                    <h6 class="mt-4">View receipt</h6>
                </div>
            </a>
         </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>