<?php
include "connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountNumber = $_POST['accountNumber'];

    $stmt = $conn->prepare("SELECT name FROM via WHERE account = ?");

    if ($stmt === false) {
        $response['error'] = "Error preparing statement: " . $conn->error;
    } else {
        $stmt->bind_param("s", $accountNumber);
        $stmt->execute();
        $stmt->bind_result($name);
        $stmt->fetch();

        if ($name) {
            $response['name'] = $name;
        } else {
            $response['name'] = null;
        }

        $stmt->close();
    }
} else {
    $response['error'] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
