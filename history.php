<?php
session_start();
    
include "connect.php";
$account = $_SESSION['account'];
$select = "SELECT * FROM `transfers` WHERE `account` = '$account' ";
$signin_details = mysqli_query($conn, $select);
$transactions = [];
while ($row = mysqli_fetch_assoc($signin_details)) {
    $transactions[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via_Bankz Account</title>
    <link href="https://cdn.jsdelivr.net/npm/boo tstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="history.css">
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Courier New', Courier, monospace !important;
    }
    .pas a{
        text-decoration: none;
    }
    .pas{
        width: 100%;
        padding: 30px;
    }
    .jus {
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .jus h6 {
        font-weight: 600;
        font-size: 20px;
    }
    .jus a {
        color: #54baac;
        font-size: 24px;
    }
    .cir{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background-color: #dae6e4;
    display: flex;
    align-items: center;
    justify-content: center;
    }
    .cir i {
        font-size: 25px;
        color: #54baac;
    }
    .transaction {
        margin-top: 20px;
        box-shadow: #63636333 0px 1px 4px 0px;
        padding: 20px;
        border-radius: 10px;
    }
    .transaction .details {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .transaction .details div {
        margin-right: 10px;
    }
    span,.details h5{
        text-transform: uppercase;
        font-weight: 600;
    }
    .transaction h5 {
        margin: 0;
    }
    .transaction button {
        width: 100px;
        height: 23px;
        background-color: #dae6e4;
        border: none;
        border-radius: 5px;
        color: #54baac;
    }
    .jus h6, #currentDate{
        color: black;
    }
</style>
<body>
    <div class="all">
        <div class="pas">
            <div class="d-flex jus">
                <a href="dashboard.php">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h6>Transaction History</h6>
                <p></p>
            </div>
            <div id="currentDate"></div>

            <div class="min mt-4">
                <?php
                for ($i = count($transactions) - 1; $i >= 0; $i--) {
                    $transaction = $transactions[$i];
                    echo '<div class="transaction">';
                    echo '<div class="details">';
                    echo '<div class="cir"><i class="bi bi-check"></i></div>';
                    echo '<div> to <span>' . $transaction['name'] . '</span></div>';
                    echo '<div><h5>₦' . $transaction['amount'] . '</h5><button>Successful</button></div>';
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function getFormattedDate() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            const now = new Date();
            const dayOfWeek = days[now.getDay()];
            const month = months[now.getMonth()];
            const dayOfMonth = now.getDate();
            const year = now.getFullYear();

            return `${dayOfWeek}, ${month} ${dayOfMonth}, ${year}`;
        }

        document.getElementById('currentDate').textContent = getFormattedDate();
    </script>

</body>
</html>
