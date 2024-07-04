<?php
    session_start();
    // Check if user is not logged in
    if (!isset($_SESSION['account'])) {
        header("Location: login.php");
        exit(); 
    }
    
    include "connect.php";
    $account = $_SESSION['account'];
    $select = "SELECT * FROM `via` WHERE `account` = '$account'";
    $signin_details = mysqli_query($conn, $select);
    $signin = mysqli_fetch_assoc($signin_details);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Via_Bankz Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="users.css">
</head>
<body>
<div class="all">
    <div class="top">
        <div class="logo">
            <img src="./images/default-monochrome-black.svg" alt="">
        </div>
        <div class="cir">
            <img src="https://i.pinimg.com/564x/e4/69/96/e4699609c34b74680f8cde19c2c433f8.jpg" alt="">
            <div class="man">
                <i class="bi bi-camera" class="tooltip-top" data-bs-toggle="tooltip" data-bs-placement="top" title="QR code scanner"  id="qr-icon" style="cursor: pointer;"></i>
            </div>
            <div class="man">
                 <span class="notification-dot" id="notificationDot"></span>
                <a href="notification.html">
                <i class="bi bi-bell"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="qr-modal" id="qrModal">
        <div class="qr-content">
            <video id="video" autoplay></video>
            <canvas id="canvas" style="display: none;"></canvas>
            <div class="d-flex gap-3">
                <div id="qr-result">No QR code detected</div>
                <div id="copy-section">
                    <span id="copy-icon" class="copy-icon bi bi-copy"></span>
                    <span id="copy-message" class="success-message"></span>
                </div>
            </div>
            <div class="jah">
                <button id="close-modal"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    </div>
    <div class="qr-popup" id="qr-popup">
        <span class="close-btn" id="close-popup">&times;</span>
        <div id="qrcode"></div>
    </div>
    <div class="body">
        <div class="side">
            <div class="fir mt-4">
                <div class="sec">
                    <a href="dashboard.php">
                        <i class="bi bi-house-add-fill"></i>
                        <p>Home</p>
                    </a>
                </div>
                <div class="sec">
                    <a href="transfer.php">
                        <i class="bi bi-cash-coin"></i>
                        <p>Transfer</p>
                    </a>
                </div>
                <div class="sec">
                    <a href="">
                        <i class="bi bi-arrow-down-left-square"></i>   
                        <p>Withdraw</p>
                    </a>
                </div>
                <div class="sec">
                    <a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-bank2"></i>
                        <p>Loan</p>
                    </a>
                </div>
                <div class="sec">
                    <a href="user.php">
                        <i class="bi bi-person"></i>
                        <p>Me</p>
                    </a>
                </div>
                <div class="sec">
                    <a href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="icons d-flex justify-content-between  fixed-bottom w-100 d-lg-none d-md-none d-block gap-2">
                <div>
                    <a href="dashboard.php" class="d-flex flex-column align-items-center">
                        <i class="bi bi-house-add-fill text-center fs-4"></i>
                        <p>Home</p>
                    </a>
                </div>
                <div>
                    <a href="transfer.php" class="d-flex flex-column align-items-center">
                        <i class="bi bi-cash-coin fs-4"></i>
                        <p>Transfer</p>
                    </a>
                </div>
                <div>
                    <a href="user.html" class="d-flex flex-column align-items-center">
                        <i class="bi bi-person fs-4"></i>
                        <p>Me</p>
                    </a>
                </div>
                <div>
                    <a href="logout.php" class="d-flex flex-column align-items-center">
                        <i class="bi bi-box-arrow-right fs-4"></i>
                        <p>Logout</p>
                    </a>
                </div>
        </div>
        <div class="main-body">
            <div class="wel">
               <div>
                <h6>Hi, <?php echo $signin['name']?></h6>
                <div class="ava">
                    <i class="bi bi-calendar2-check"></i>  
                    <p data-tooltip="Price:-#2700">Total Balance</p>
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="Hide balance"  id="toggleIcon" class="bi bi-eye"></i>
                </div>
                <div class="d-flex gal">
                    <h2 id="balance" class="balance">₦14,475.40</h2>
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="Scan QR code"  id="scan" class="bi bi-qr-code-scan tooltip-top"></i>
                 </div>
                <div class="d-flex gap-2 tip">
                    <p>Acc No: <span id="number"><?php echo $signin ['account'] ?></span> </p> 
                    <i class="bi bi-copy tooltip-top" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy QR code" id="copyAccountNumber"></i>
                    <div class="copy-message" id="copyMessage">Copied!</div>
                </div>
               </div>
            </div>
            <div class="wen mt-4">
                <h6>Personal Information</h6>
                <div class="wens">
                    <div>
                        <h6>Name</h6>
                        <h5><?php echo $signin['name']?></h5>
                    </div>
                    <div class="mt-4">
                        <h6>Email</h6>
                        <h5><?php echo $signin['email']?></h5>
                    </div>
                    <div class="mt-4">
                        <h6>Phone Number</h6>
                        <h5><?php echo $signin['account']?></h5>
                    </div>
                </div>
            </div>
            <div class="wene mt-4">
                <h6>Actions</h6>
                <div class="wens">
                    <a href="notification.html">
                        <div class="fol d-flex">
                            <div class="d-flex gap-2">
                                <div class="ban ">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <h6 class="mt-2">Notifications</h6>
                            </div>
                            <i class="bi bi-caret-left-fill"></i>
                         </div>
                    </a>
                    <div class="mt-4">
                        <a href="history.php" class="">
                            <div class="fol d-flex">
                                <div class="d-flex gap-2">
                                    <div class="ban">
                                        <i class="bi bi-calendar-fill"></i>
                                    </div>
                                    <h6 class="mt-2">Transaction History</h6>
                                </div>
                                <i class="bi bi-caret-left-fill"></i>
                            </div>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="login.php" class="">
                            <div class="fol d-flex">
                                <div class="d-flex gap-2">
                                    <div class="ban">
                                        <i class="bi bi-arrow-right-square-fill"></i>
                                    </div>
                                    <h6 class="mt-2">Logout</h6>
                                </div>
                                <i class="bi bi-caret-left-fill"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

    const qrIcon = document.getElementById('qr-icon');
    const qrModal = document.getElementById('qrModal');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d', { willReadFrequently: true });
    const qrResult = document.getElementById('qr-result');
    const copyIcon = document.getElementById('copy-icon');
    const copyMessage = document.getElementById('copy-message');
    const qrPopup = document.getElementById('qr-popup');
    const qrcodeContainer = document.getElementById('qrcode');

    qrIcon.addEventListener('click', () => {
        qrModal.style.display = 'flex';
        startCamera();
    });

    const qrcon = document.getElementById('scan');

    qrcon.onclick = () => {
        const storedWalletAddress = localStorage.getItem('walletAddress');
        if (storedWalletAddress) {
            QRCode.toDataURL(storedWalletAddress, { width: 200, height: 200 }, (err, url) => {
                if (err) {
                    console.error("QR Code generation failed: ", err);
                } else {
                    qrcodeContainer.innerHTML = `<img src="${url}" alt="QR Code"><br><p><?php echo $signin ['account']?></p>`;
                    qrPopup.style.display = 'block';
                }
            });
        } else {
            alert("Wallet address not found. Please login again.");
            window.location.href = "account.html";
        }
    };

    const closePopup = document.getElementById('close-popup');
    closePopup.onclick = () => {
        qrPopup.style.display = 'none';
    };

    window.onclick = (event) => {
        if (event.target == qrPopup) {
            qrPopup.style.display = 'none';
        }
    };

    const closeModalBtn = document.getElementById('close-modal');
    closeModalBtn.addEventListener('click', () => {
        qrModal.style.display = 'none';
        stopCamera();
    });

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(stream => {
                video.srcObject = stream;
                scanQRCode();
            })
            .catch(err => {
                console.error('Error accessing the camera: ', err);
            });
    }

    function stopCamera() {
        const stream = video.srcObject;
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    }

    function scanQRCode() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {
                qrResult.textContent = code.data;
                stopCamera(); 
                return;
            } else {
                qrResult.textContent = 'No QR Code detected';
            }
        }
        requestAnimationFrame(scanQRCode);
    }

    copyIcon.addEventListener('click', () => {
        const qrCodeText = qrResult.textContent;
        navigator.clipboard.writeText(qrCodeText)
            .then(() => {
                copyMessage.textContent = 'Copied!';
                setTimeout(() => {
                    copyMessage.textContent = '';
                }, 2000);
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
            });
    });

    document.addEventListener("DOMContentLoaded", () => {

        document.getElementById('toggleIcon').addEventListener('click', function() {
            var balanceElement = document.getElementById('balance');
            var iconElement = document.getElementById('toggleIcon');
            if (balanceElement.textContent === '****') {
                balanceElement.textContent = '₦14,475.40';
                iconElement.classList.remove('fa-eye-slash');
                iconElement.classList.add('fa-eye');
            } else {
                balanceElement.textContent = '****';
                iconElement.classList.remove('fa-eye');
                iconElement.classList.add('fa-eye-slash');
            }
        });

        document.getElementById('seeAll').addEventListener('click', function() {
            var hiddenItems = document.querySelectorAll('.tec .hidden');
            hiddenItems.forEach(function(item) {
                item.classList.remove('hidden');
            });
            document.getElementById('seeAllContainer').style.display = 'none';
        });

        document.getElementById('copyAccountNumber').addEventListener('click', () => {
            const accountNumberElement = document.getElementById('number');
            const accountNumber = accountNumberElement.textContent;

            navigator.clipboard.writeText(accountNumber).then(() => {
                var copyMessage = document.getElementById("copyMessage");
                copyMessage.style.display = "block";
                setTimeout(function() {
                    copyMessage.style.display = "none";
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
                alert('Failed to copy account number. Please try again.');
            });
        });
    });
    function updateNotificationDot() {
        const dot = document.getElementById('notificationDot');
        const unreadNotifications = 2;
        if (unreadNotifications > 0) {
            dot.style.display = 'block';
        } else {
            dot.style.display = 'none';
        }
    }
    function notificationsRead() {
        updateNotificationDot(); 
    }

    updateNotificationDot();
</script>
</body>
</html>

