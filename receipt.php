<?php
include "connect.php";
session_start();

$account = $_SESSION['account'];
$select = "SELECT * FROM transfers WHERE account = '$account' ORDER BY `id` DESC";
$selet = "SELECT * FROM via WHERE account = '$account' ORDER BY `id` DESC";
$signin_details = mysqli_query($conn, $select);
$signin =  mysqli_fetch_assoc($signin_details);
$set = mysqli_query($conn, $selet);
$sets =  mysqli_fetch_assoc($set);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="receipt.css">
</head>
<style>
    .ica i{
    color: #54baac;
    font-size: 600;
    }
    .lal{
    width: 100%;
    padding: 20px 30px 20px 30px;
    background-color: #54baac;
    color: white;
    }
    .dropdown-menu{
    background-color: #54baac;
    width: 100%;
   }
   .dropdown-item{
    font-size: 16px !important;
   }
   .car h4{
    font-weight: 600;
    font-size: 18px !important;
    }
    .lal a{
    margin-bottom: 10px !important;
    color: white;
    font-size: 23px;
    }
</style>
<body>
    <div class="all">
        <div class="lal">
            <a href="dashboard.php" class="">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="lag d-flex mt-3">
                <div class="logo">
                    <img src="./images/default-monochrome-black.svg" alt="" crossorigin="anonymous">
                </div>
                <h6>Transaction Receipt</h6>
            </div>
            <div class="bola mt-4">
                <h5>Transaction Success</h5>
                <div class="ball mt-3">
                    <div class="d-flex gap-2">
                        <div class="ica">
                            <i class="bi bi-calendar-plus-fill"></i>
                        </div>
                        <div class="car">
                            <h6>Total Amount</h6>
                            <h4>₦<?php echo $signin['amount']?></h4>
                        </div>
                    </div>
                    <div class="line d-flex gap-3 mt-4">
                        <div class="lie"></div>
                        <h6>Successfully sent to</h6>
                        <div class="lie"></div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="car">
                            <h6>Transaction Type</h6>
                            <h4>Transfer to bank</h4>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                        <div class="car">
                            <h6>Recipient Details</h6>
                            <h4><?php echo $signin['name']?></h4>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="car">
                            <h6>Sender Details</h6>
                            <h4><?php echo $sets['name']?></h4>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="car">
                            <h6>Remark</h6>
                            <h4><?php echo $signin['remark']?></h4>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-alarm-fill"></i>
                        </div>
                        <div class="car">
                            <h6 class="date mt-2"></h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <div class="ica">
                            <i class="bi bi-person-raised-hand"></i>
                        </div>
                        <div class="car">
                            <h6 class="mt-2">Thanks for using iviabank👌</h6>
                        </div>
                    </div>
                </div>
                <div class="bin">
                    <div class="dropdown">
                        <button class="buttonDownload  dropdown-toggle" type="button" id="downloadReceiptButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Download Receipt
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="downloadReceiptButton">
                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('image')">Download as Image</a></li>
                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('pdf')">Download as PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function updateDateTime() {
            const dateElement = document.querySelector('.date');
            const now = new Date();
            const formattedDateTime = now.toLocaleString(); 
            dateElement.textContent = formattedDateTime;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        function downloadReceipt(format) {
            const downloadButton = document.querySelector('.bin');
            const logoImage = document.querySelector('.logo img');

            logoImage.onload = () => {
                downloadButton.style.display = 'none';

                if (format === 'image') {
                    html2canvas(document.querySelector('.lal')).then(canvas => {
                        const link = document.createElement('a');
                        link.href = canvas.toDataURL('image/png');
                        link.download = 'receipt.png';
                        link.click();
                        downloadButton.style.display = 'block';
                    });
                } else if (format === 'pdf') {
                    const element = document.querySelector('.lal');
                    const opt = {
                        margin: 1,
                        filename: 'receipt.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };
                    html2pdf().from(element).set(opt).save().then(() => {
                        downloadButton.style.display = 'block';
                    });
                }
            };
            if (logoImage.complete) {
                logoImage.onload();
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
</html>
