<?php
session_start();
include "connect.php";
$errorMsg = ""; 
if(isset($_POST["submit"])){
    $account = $_POST['account-number'];
    $password = $_POST['password'];
    
    $result = mysqli_query($conn, "SELECT * FROM `via` WHERE `account` = '$account' AND `password` = '$password'");
    
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION["account"] = $user["account"];
         $_SESSION["password"] = $user["password"];
        
         header("location:dashboard.php");
        } 
        else {
            $errorMsg = '<h6 style="color: red; margin-top:10px;">Account doesnt exist</h6>';
    }
}

?>


<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via_Bankz Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@700" />
    <link rel="stylesheet" href="account.css">
    <style>
        .avatar {
            width: 80px;
        }
        form h2 {
            font-size: 2.9rem;
            font-weight: 500;
            text-transform: uppercase;
            margin: 0px 0;
            color: #333;
        }
        #qr-scanner-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.75);
            z-index: 1000;
            height: 550px;
            padding: 70px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 45%;
        }
        #reader {
            width: 440px;
            height: 500px;
            margin-bottom: 30px;
        }
        #close-scanner, #refresh-scanner {
            position: absolute;
            top: 10px;
            background: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        #close-scanner {
            right: 10px;
        }
        #refresh-scanner {
            right: 60px;
        }
        #qr-message {
            color: white;
        }
        #qr-code-message{
            word-wrap: break-word; 
            word-break: break-all; 
        }
        .kan {
            flex-direction: column;
        }
        #qr-message {
            text-align: center;
        }
        #copy-button {
            background-color: transparent;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: -10px;
            color: #54baac;
            font-size: 23px;
        }
        #copy-status {
            color: white;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="all">
        <svg xmlns="http://www.w3.org/2000/svg" width="498.23px" height="644px" viewBox="0 0 620.23 789.73" style="overflow:visible;">
            <style type="text/css">
                .st0{fill:#54baac;stroke-miterlimit:10;}
            </style>
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
                    <div class="d-flex bii gap-1">
                        <div class="ada">
                            <label for="account-number">Your account number</label>
                            <input value="<?php echo isset($_POST['account-number']) ? htmlspecialchars($_POST['account-number']) : ''; ?>" type="text" name="account-number" id="account-number" placeholder="Wallet address" required>
                        </div>
                        <span class="material-symbols-outlined" id="qr-icon" style="cursor: pointer;">
                            barcode_scanner
                        </span>
                    </div>
                    <div class="ada">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="*********">
                    </div>
                    <div class="d-flex bab">
                        <h6>Don't have an account? </h6>
                        <a href="signup.html">Signup</a>
                    </div>
                    <?php echo $errorMsg; ?>
                    <button type="submit" name="submit" id="login-btn" class="btn mt-5">Login</button>
                </form>
            </div>
        </div>
    </div>
    <div id="qr-scanner-container">
        <button id="close-scanner"><i class="fa-solid fa-xmark"></i></button>
        <button id="refresh-scanner"><i class="fa-solid fa-arrows-rotate"></i></button>
        <div class="d-flex kan">
            <div id="reader"></div>
            <div class="d-flex">
                <div id="qr-message">
                    <strong>QR code detected:</strong>
                     <span id="qr-code-message"></span>
                </div>
                <button id="copy-button"><i class="fa-regular fa-copy"></i></button>
                <div id="copy-status"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const walletAddress = localStorage.getItem('walletAddress');
            if (walletAddress) {
                document.getElementById('account-number').value = walletAddress;
            } else {
                alert("Wallet address not found. Please connect wallet first.");
                window.location.href = "index.html"; 
            }

            const qrIcon = document.getElementById('qr-icon');
            const qrScannerContainer = document.getElementById('qr-scanner-container');
            const closeScannerButton = document.getElementById('close-scanner');
            const refreshScannerButton = document.getElementById('refresh-scanner');
            const qrCodeMessageElement = document.getElementById('qr-code-message');
            const accountNumberInput = document.getElementById('account-number');
            const copyButton = document.getElementById('copy-button');
            const copyStatus = document.getElementById('copy-status');

            let html5QrcodeScanner;

            function startScanner() {
                html5QrcodeScanner = new Html5Qrcode("reader");
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    {
                        fps: 10, 
                        qrbox: { width: 500, height: 700 }  // Increased size of qrbox
                    },
                    qrCodeMessage => {
                        console.log("QR Code scanned: " + qrCodeMessage);
                        qrCodeMessageElement.textContent = qrCodeMessage;
                        accountNumberInput.value = qrCodeMessage;
                    },
                    errorMessage => {
                        console.error("QR Code scan error: " + errorMessage);
                    })
                    .catch(err => {
                        console.error("Unable to start scanning.", err);
                    });
            }

            qrIcon.addEventListener('click', () => {
                qrScannerContainer.style.display = 'flex';
                startScanner();
            });

            closeScannerButton.addEventListener('click', () => {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(ignore => {
                        qrScannerContainer.style.display = 'none';
                    }).catch(err => {
                        console.error("Failed to stop scanner.");
                    });
                } else {
                    qrScannerContainer.style.display = 'none';
                }
            });

            refreshScannerButton.addEventListener('click', () => {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(ignore => {
                        qrCodeMessageElement.textContent = "";
                        startScanner();
                    }).catch(err => {
                        console.error("Failed to refresh scanner.", err);
                    });
                }
            });

            copyButton.addEventListener('click', () => {
                const qrCodeMessage = qrCodeMessageElement.textContent.trim();
                navigator.clipboard.writeText(qrCodeMessage).then(() => {
                    copyStatus.textContent = "Copied!";
                    setTimeout(() => {
                        copyStatus.textContent = "";
                    }, 2000);
                }).catch(err => {
                    console.error("Failed to copy text: ", err);
                });
            });
        });
    </script>
</body>
</html>