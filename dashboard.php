<?php
    session_start();
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
<?php
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
    <title>Via_Bankz Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/93483deb2b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="dashboard.css">
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">LOAN</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              We apologize, but there are no loans available
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
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
                    <a href="user.php" class="d-flex flex-column align-items-center">
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
                <h6>Welcome, <?php echo $signin['name']?></h6>
                <div class="ava">
                    <i class="bi bi-calendar2-check"></i>   
                    <p data-tooltip="Price:-#2700">Available Balance</p>
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="Hide balance"  id="toggleIcon" class="bi bi-eye"></i>
                </div>
                <div class="d-flex gal">
                    <h2 id="balance" class="balance">₦<?php echo $signin['balance']?></h2>
                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="Scan QR code"  id="scan" class="bi bi-qr-code-scan tooltip-top"></i>
                 </div>
                <div class="d-flex gap-2 tip">
                    <p>Acc No: <span id="number"><?php echo $signin ['account'] ?></span> </p> 
                    <i class="bi bi-copy tooltip-top" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy QR code" id="copyAccountNumber"></i>
                    <div class="copy-message" id="copyMessage">Copied!</div>
                </div>
                <div class="boxes">
                    <div class="bax">
                        <a href="transfer.php">
                            <div class="box ">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                        </a>
                        <p >Transfer</p>
                    </div>
                    <div class="bax">
                        <div class="box ">
                            <i class="bi bi-arrow-down-left-square"></i>
                        </div>
                        <p >Withdraw</p>
                    </div>
                    <div class="bax">
                        <div class="box " data-bs-toggle="moda12" data-bs-target="#staticBackdrop">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <p >Card</p>
                    </div>
                    <div class="bax">
                        <a href="history.php">
                            <div class="box ">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <p >History</p>
                        </a>
                    </div>
                </div>
               </div>
               <div class="wave">
                    <img src="https://media.tenor.com/RWpw4DRG_hAAAAAi/man.gif" alt="">
                </div>
            </div>
            <script src="https://widgets.coingecko.com/coingecko-coin-price-marquee-widget.js"></script>
            <div class="mt-3">
             <coingecko-coin-price-marquee-widget  coin-ids="bitcoin,ethereum,eos,ripple,litecoin" currency="usd" background-color="#54baac" locale="en"></coingecko-coin-price-marquee-widget>
            </div>
            <div class="mad row mt-3">
                <div class="col-lg-6 col-12">
                    <div class="othe mt-4 ">
                        <div class="ati">
                            <div class="eje">
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-phone-fill"></i>
                                    </div>
                                    <p>Airtime</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-clipboard2-data-fill"></i>
                                    </div>
                                    <p>Data</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-dribbble"></i>
                                    </div>
                                    <p>Betting</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-tv-fill"></i>
                                    </div>
                                    <p> TV</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-bank2"></i>
                                    </div>
                                    <p>Loan</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-lightbulb-fill"></i>
                                    </div>
                                    <p>Electricity</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-bank2"></i>
                                    </div>
                                    <p>Loan</p>
                                </div>
                                <div class="sep">
                                    <div class="man">
                                        <i class="bi bi-alarm-fill"></i>
                                    </div>
                                    <p>Savings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards mt-4">
                        <div class="outlinePage">
                        <svg
                            class="icon trophy"
                            viewBox="0 0 1024 1024"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="160"
                            height="160"
                        >
                            <path
                            d="M469.333333 682.666667h85.333334v128h-85.333334zM435.2 810.666667h153.6c4.693333 0 8.533333 3.84 8.533333 8.533333v34.133333h-170.666666v-34.133333c0-4.693333 3.84-8.533333 8.533333-8.533333z"
                            fill="#ea9518"
                            data-spm-anchor-id="a313x.search_index.0.i10.40193a81WcxQiT"
                            class=""
                            ></path>
                            <path
                            d="M384 853.333333h256a42.666667 42.666667 0 0 1 42.666667 42.666667v42.666667H341.333333v-42.666667a42.666667 42.666667 0 0 1 42.666667-42.666667z"
                            fill="#6e4a32"
                            data-spm-anchor-id="a313x.search_index.0.i1.40193a81WcxQiT"
                            class=""
                            ></path>
                            <path
                            d="M213.333333 256v85.333333a42.666667 42.666667 0 0 0 85.333334 0V256H213.333333zM170.666667 213.333333h170.666666v128a85.333333 85.333333 0 1 1-170.666666 0V213.333333zM725.333333 256v85.333333a42.666667 42.666667 0 0 0 85.333334 0V256h-85.333334z m-42.666666-42.666667h170.666666v128a85.333333 85.333333 0 1 1-170.666666 0V213.333333z"
                            fill="#f4ea2a"
                            data-spm-anchor-id="a313x.search_index.0.i9.40193a81WcxQiT"
                            class=""
                            ></path>
                            <path
                            d="M298.666667 85.333333h426.666666a42.666667 42.666667 0 0 1 42.666667 42.666667v341.333333a256 256 0 1 1-512 0V128a42.666667 42.666667 0 0 1 42.666667-42.666667z"
                            fill="#f2be45"
                            data-spm-anchor-id="a313x.search_index.0.i5.40193a81WcxQiT"
                            class=""
                            ></path>
                            <path
                            d="M512 469.333333l-100.309333 52.736 19.157333-111.701333-81.152-79.104 112.128-16.298667L512 213.333333l50.176 101.632 112.128 16.298667-81.152 79.104 19.157333 111.701333z"
                            fill="#FFF2A0"
                            ></path>
                        </svg>
                        <p ><span class="ranking_word">Referal Bonus</span></p>
                        <div class="splitLine"></div>
                        <svg
                            class="icon userAvatar"
                            viewBox="0 0 1024 1024"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="25"
                            height="25"
                        >
                            <path
                            d="M512 0C228.693 0 0 228.693 0 512s228.693 512 512 512 512-228.693 512-512S795.307 0 512 0z m0 69.973c244.053 0 442.027 197.973 442.027 442.027 0 87.04-25.6 168.96-69.973 237.227-73.387-78.507-170.667-133.12-281.6-151.893 69.973-34.133 119.467-105.813 119.467-187.733 0-116.053-93.867-209.92-209.92-209.92s-209.92 93.867-209.92 209.92c0 83.627 47.787 155.307 119.467 187.733-110.933 20.48-208.213 75.093-281.6 153.6-44.373-68.267-69.973-150.187-69.973-238.933 0-244.053 197.973-442.027 442.027-442.027z"
                            fill="#8a8a8a"
                            ></path>
                        </svg>
                        <p class="userName"> <?php echo $signin['name']?></p>
                        </div>
                        <div class="detailPage">
                        <svg
                            class="icon medals slide-in-top"
                            viewBox="0 0 1024 1024"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="80"
                            height="80"
                        >
                            <path
                            d="M896 42.666667h-128l-170.666667 213.333333h128z"
                            fill="#FF4C4C"
                            ></path>
                            <path
                            d="M768 42.666667h-128l-170.666667 213.333333h128z"
                            fill="#3B8CFF"
                            ></path>
                            <path d="M640 42.666667h-128L341.333333 256h128z" fill="#F1F1F1"></path>
                            <path
                            d="M128 42.666667h128l170.666667 213.333333H298.666667z"
                            fill="#FF4C4C"
                            ></path>
                            <path
                            d="M256 42.666667h128l170.666667 213.333333h-128z"
                            fill="#3B8CFF"
                            ></path>
                            <path
                            d="M384 42.666667h128l170.666667 213.333333h-128z"
                            fill="#FBFBFB"
                            ></path>
                            <path
                            d="M298.666667 256h426.666666v213.333333H298.666667z"
                            fill="#E3A815"
                            ></path>
                            <path
                            d="M512 661.333333m-320 0a320 320 0 1 0 640 0 320 320 0 1 0-640 0Z"
                            fill="#FDDC3A"
                            ></path>
                            <path
                            d="M512 661.333333m-256 0a256 256 0 1 0 512 0 256 256 0 1 0-512 0Z"
                            fill="#E3A815"
                            ></path>
                            <path
                            d="M512 661.333333m-213.333333 0a213.333333 213.333333 0 1 0 426.666666 0 213.333333 213.333333 0 1 0-426.666666 0Z"
                            fill="#F5CF41"
                            ></path>
                            <path
                            d="M277.333333 256h469.333334a21.333333 21.333333 0 0 1 0 42.666667h-469.333334a21.333333 21.333333 0 0 1 0-42.666667z"
                            fill="#D19A0E"
                            ></path>
                            <path
                            d="M277.333333 264.533333a12.8 12.8 0 1 0 0 25.6h469.333334a12.8 12.8 0 1 0 0-25.6h-469.333334z m0-17.066666h469.333334a29.866667 29.866667 0 1 1 0 59.733333h-469.333334a29.866667 29.866667 0 1 1 0-59.733333z"
                            fill="#F9D525"
                            ></path>
                            <path
                            d="M512 746.666667l-100.309333 52.736 19.157333-111.701334-81.152-79.104 112.128-16.298666L512 490.666667l50.176 101.632 112.128 16.298666-81.152 79.104 19.157333 111.701334z"
                            fill="#FFF2A0"
                            ></path>
                        </svg>
                        <div class="gradesBox">
                            <svg
                            class="icon gradesIcon"
                            viewBox="0 0 1024 1024"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="60"
                            height="60"
                            >
                            <path
                                d="M382.6 805H242.2c-6.7 0-12.2-5.5-12.2-12.2V434.3c0-6.7 5.5-12.2 12.2-12.2h140.4c6.7 0 12.2 5.5 12.2 12.2v358.6c0 6.6-5.4 12.1-12.2 12.1z"
                                fill="#ea9518"
                                data-spm-anchor-id="a313x.search_index.0.i36.40193a81WcxQiT"
                                class=""
                            ></path>
                            <path
                                d="M591.1 805H450.7c-6.7 0-12.2-5.5-12.2-12.2V254.9c0-6.7 5.5-12.2 12.2-12.2h140.4c6.7 0 12.2 5.5 12.2 12.2v537.9c0 6.7-5.5 12.2-12.2 12.2z"
                                fill="#f2be45"
                                data-spm-anchor-id="a313x.search_index.0.i35.40193a81WcxQiT"
                                class=""
                            ></path>
                            <path
                                d="M804.4 805H663.9c-6.7 0-12.2-5.5-12.2-12.2v-281c0-6.7 5.5-12.2 12.2-12.2h140.4c6.7 0 12.2 5.5 12.2 12.2v281c0.1 6.7-5.4 12.2-12.1 12.2z"
                                fill="#ea9518"
                                data-spm-anchor-id="a313x.search_index.0.i37.40193a81WcxQiT"
                                class=""
                            ></path>
                            </svg>
                            <p class="gradesBoxLabel">AMOUNT</p>
                            <p class="gradesBoxNum">0.00</p>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="rec col-lg-6 col-12">
                    <div class="d-flex oga mt-4">
                        <div>
                            <h6>Recent Activity</h6>
                        </div>
                        <div id="seeAllContainer" class="d-flex gil">
                            <h6 id="seeAll">See all </h6>
                            <i class="fa-solid fa-greater-than"></i>
                        </div>
                    </div>

                    <div class="min mt-4">
                        <?php
                        for ($i = count($transactions) - 1; $i >= 0; $i--) {
                            $transaction = $transactions[$i];
                            echo '<div class="transaction">';
                            echo '<div class="details">';
                            echo '<div class="det">';
                            echo '<div class="cirs"><img src="https://i.pinimg.com/564x/5e/33/cb/5e33cbc8ef7e1077aa900eb19c3b0137.jpg" alt=""></div>';
                            echo '<div class="lat"> to <span>' . $transaction['name'] . '</span></div>';
                            echo '</div>';
                            echo '<div><div class="can"><i class="bi bi-dash"></i><h5>₦' . $transaction['amount'] . '</h5></div><button>Successful</button></div>';
                            echo '</div></div>';
                        }
                ?>
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

