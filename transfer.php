<?php
session_start();
include "connect.php";

$account = $_SESSION['account'];
$select = "SELECT * FROM via WHERE account = '$account'";
$signin_details = mysqli_query($conn, $select);
$signin = mysqli_fetch_assoc($signin_details);

$errorMsg = ""; 

if (isset($_POST["submit"])) {
    $account = $_POST['account'];
    $recipient_account = $_POST['recipient_account']; 
    $bank  = $_POST['bank'];
    $remark  = $_POST['remark'];
    $amount = $_POST['amount'];
    $name = $_POST['name'];
    $new_pin = $_POST['new_pin'] ?? null;
    $pin = $_POST['pin'] ?? null;
    
    $_SESSION["form_data"] = $_POST;
    
    if (empty($account) || empty($recipient_account) || empty($bank) || empty($remark) || empty($amount) || empty($name)) {
        $errorMsg = '<h6 style="color: red;">Insignificant amount</h6>';  
    } else {
        $recipient_check = mysqli_query($conn, "SELECT * FROM via WHERE account = '$recipient_account'");
        if (mysqli_num_rows($recipient_check) > 0) {
            $recipient = mysqli_fetch_assoc($recipient_check);
            $new_balance = $recipient['balance'] + $amount;

            if ($signin['balance'] >= $amount) {
                $new_sender_balance = $signin['balance'] - $amount;

                if (empty($signin['pin'])) {
                    if (empty($new_pin) || strlen($new_pin) !== 4) {
                        $errorMsg = '<h6 style="color: red !important; margin-top:10px;">Please set a valid 4-digit PIN</h6>';
                    } else {
                        mysqli_query($conn, "UPDATE via SET pin = '$new_pin' WHERE account = '$account'");
                        $signin['pin'] = $new_pin; 
                    }
                } elseif ($pin !== $signin['pin']) {
                    $errorMsg = '<h6 style="color: red; margin-top:10px;">Incorrect PIN</h6>';
                } else {
                    mysqli_begin_transaction($conn);
                    try {
                        mysqli_query($conn, "INSERT INTO transfers(account, recipient_account, bank, remark, amount, name) VALUES ('$account', '$recipient_account','$bank', '$remark', '$amount', '$name')");

                        mysqli_query($conn, "UPDATE via SET balance = '$new_balance' WHERE account = '$recipient_account'");

                        mysqli_query($conn, "UPDATE via SET balance = '$new_sender_balance' WHERE account = '$account'");

                        mysqli_commit($conn);

                        $errorMsg = '<h6 style="color: red; margin-top:10px;">Success</h6>';
                        header("location:Success.php?success=". $account);
                        exit();
                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        $errorMsg = '<h6 style="color: red; margin-top:10px;">Error inserting record</h6>';
                    }
                }
            } else {
                $errorMsg = '<h6 style="color: red; margin-top:10px;">Insufficient balance</h6>';
            }
        } else {
            $errorMsg = '<h6 style="color: red; margin-top:10px;">Recipient account does not exist</h6>';
        }
    }
}
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
    <link rel="stylesheet" href="transfer.css">
</head>
<body>
    <div class="all">
        <div class="goo">
            <div class="tap d-flex">
                <a href="dashboard.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h6>New Transfer</h6>
                <a href="history.html">
                    <i class="fa-regular fa-clock"></i>
                </a>
            </div>
            <div class="fle mt-4">
                <p>Transfer From</p>
                <div class="loader" id="loader">
                    <div class="loaders"></div>
                </div>
                <div class="box">
                    <img src="./images/default-monochrome-black.svg" alt="">
                    <div class="name">
                        <h6 class="nam"><?php echo $signin['name']?></h6>
                        <p>Account Number: <span id="umber"><?php echo $signin['account']?></span></p>
                        <p class="aye">Balance: ₦<span id="balance"><?php echo $signin['balance']?></span></p>
                    </div>
                </div>
            </div>
            <div class="woo mt-4">
            <p>New Beneficiary</p>
            <form id="transferForm" action="transfer.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <div class="">
                        <input type="hidden" name="account" id="account" required value="<?= $signin['account']?>">
                    </div>
                </div>
                <div class="d-flex dat gap-4">
                    <div class="odo">
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-landmark"></i></span>
                            <input type="text" name="recipient_account" id="recipient_account" required>
                            <label for="number">Recipient Account Number</label>
                        </div>
                    </div>
                    <div class="odo">
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <select id="bank" name="bank" required>
                            <option value="firstbank">FirstBank</option>
                                        <option value="uba">United Bank for Africa (UBA)</option>
                                        <option value="zenith">Zenith Bank</option>
                                        <option value="gtbank">Guaranty Trust Bank (GTBank)</option>
                                        <option value="access">Access Bank</option>
                                        <option value="iviabank">iviabank</option>
                                        <option value="fidelity">Fidelity Bank</option>
                                        <option value="union">Union Bank</option>
                                        <option value="ecobank">Ecobank</option>
                                        <option value="stanbic">Stanbic IBTC Bank</option>
                                        <option value="sterling">Sterling Bank</option>
                                        <option value="keystone">Keystone Bank</option>
                                        <option value="wema">Wema Bank</option>
                                        <option value="fcmb">First City Monument Bank (FCMB)</option>
                                        <option value="heritage">Heritage Bank</option>
                                        <option value="unity">Unity Bank</option>
                                        <option value="polaris">Polaris Bank</option>
                                        <option value="citibank">Citibank</option>
                                        <option value="standardchartered">Standard Chartered Bank</option>
                                        <option value="providus">Providus Bank</option>
                                        <option value="jaiz">Jaiz Bank</option>
                                        <option value="suntrust">SunTrust Bank</option>
                                        <option value="chase">Chase Bank</option>
                                        <option value="boa">Bank of America</option>
                                        <option value="wellsfargo">Wells Fargo</option>
                                        <option value="usbank">U.S. Bank</option>
                                        <option value="pnc">PNC Bank</option>
                                        <option value="tdbank">TD Bank</option>
                                        <option value="bbt">BB&T</option>
                                        <option value="capitalone">Capital One</option>
                                        <option value="ally">Ally Bank</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex dat gap-4 mt-4">
                    <div class="odo">
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" id="name" required>
                            <label for="name" >Recipient Name</label>
                        </div>
                    </div>
                    <div class="odo">
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-money-bill"></i></span>
                            <input type="number" name="amount" id="amount" required>
                            <label for="amount">Amount</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex dat gap-4 mt-4">
                    <div class="odo">
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-pen"></i></span>
                            <textarea name="remark" id="remark" ></textarea>
                            <label for="remark">Remark</label>
                        </div>
                    </div>
                    <?php if (empty($signin['pin'])): ?>
                        <div class="odo">
                            <div class="input-box">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="new_pin" id="new_pin" required>
                                <label for="new_pin">Create your 4-digit PIN</label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="odo">
                            <div class="input-box">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="pin" id="pin"  required>
                                <label for="pin">Enter 4-digit PIN</label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="lolo">
                    <button type="submit" class="btns mt-4" name="submit">Transfer</button>
                </div>
            </form>
        </div>
        <div class="overlay" id="overlay"></div>
                <div class="error-popup" id="errorPopup">
                    <button class="close-btn" onclick="closePopup()">×</button>
                    <div id="errorMessage"><?php echo $errorMsg; ?></div>
                </div>
            </div>
    </div>

        <div id="message"></div>
    </div>
    <script>
    function closePopup() {
        document.getElementById('errorPopup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
    
    window.onload = function() {
        <?php if (!empty($errorMsg)): ?>
            document.getElementById('errorPopup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        <?php endif; ?>
    }
</script>
    <script src="transfer.js"></script>
</body>
</html>

