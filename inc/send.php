<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = htmlspecialchars(trim($_POST['conName'] ?? ''));
    $lastName  = htmlspecialchars(trim($_POST['conLName'] ?? ''));
    $email     = filter_var(trim($_POST['conEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone     = htmlspecialchars(trim($_POST['conPhone'] ?? ''));
    $service   = htmlspecialchars(trim($_POST['conService'] ?? ''));
    $message   = htmlspecialchars(trim($_POST['conMessage'] ?? ''));

    if (empty($firstName) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "fail", "error" => "Invalid input"]);
        exit;
    }

    $to      = "hello@aboutmichael.dev"; // 🔴 replace with your email
    $subject = "New Contact Form Submission";
    $body    = "You have a new message:\n\n"
             . "Name: $firstName $lastName\n"
             . "Email: $email\n"
             . "Phone: $phone\n"
             . "Service: $service\n\n"
             . "Message:\n$message\n";
    $headers = "From: $firstName <$email>\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "fail", "error" => "Mail error"]);
    }
    exit;
}

echo json_encode(["status" => "fail", "error" => "Invalid request"]);
