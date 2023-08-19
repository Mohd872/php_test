<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
require 'class.smtp.php'; 
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$errors = [];
$full_name = sanitizeInput($_POST['full_name']);
$phone_number = sanitizeInput($_POST['phone_number']);
$email = sanitizeInput($_POST['email']);
$subject = sanitizeInput($_POST['subject']);
$message = sanitizeInput($_POST['message']);

if (empty($full_name)) {
    $errors[] = "Full Name is required";
}

if (empty($phone_number)) {
    $errors[] = "Phone Number is required";
} elseif (!preg_match("/^[0-9]{10}$/", $phone_number)) {
    $errors[] = "Phone Number is invalid";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email is invalid";
}

if (empty($subject)) {
    $errors[] = "Subject is required";
}

if (empty($message)) {
    $errors[] = "Message is required";
}

if (count($errors) === 0) {
   include "config.php";
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $timestamp = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO contact_form (full_name, phone_number, email, subject, message, ip_address, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $full_name, $phone_number, $email, $subject, $message, $ip_address, $timestamp);

    if ($stmt->execute()) {
    
        try {
           
             $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'salllu2212@gmail.com'; 
            $mail->Password   = '12345678'; 
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('salllu2212@gmail.com'); 
            $mail->addAddress('mohdsalauddin12554@gmail.com'); 

            // Content
            $mail->isHTML(false);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Full Name: $full_name\nPhone Number: $phone_number\nEmail: $email\nSubject: $subject\nMessage: $message\nIP Address: $ip_address\nTimestamp: $timestamp";

          $result=  $mail->send();
          print_r($result);
            $success_message = "Form submitted successfully";
        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $stmt->close();
        $conn->close();
    } else {
        $errors[] = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Submission</title>
</head>
<body>
    <?php if (count($errors) > 0): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div style="color: green;">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
</body>
</html>
