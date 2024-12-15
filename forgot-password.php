<?php
session_start();
require_once "config.php"; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

function generateOtp($length = 6) {
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cEmail'])) {
    $cemail = htmlspecialchars(trim($_POST["cEmail"])); 
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM tbuser WHERE email = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error); 
    }
    $stmt->bind_param("s", $cemail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $otp = generateOtp();
        
        $update_stmt = $conn->prepare("UPDATE tbuser SET otp = ? WHERE email = ?");
        if (!$update_stmt) {
            die("Error preparing update statement: " . $conn->error);
        }
        $update_stmt->bind_param("ss", $otp, $cemail);
        $update_stmt->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'violetteror66@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'ktlg cbam bhlt etno'; // Ganti dengan app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Penerima email
            $mail->setFrom('violetteror66@gmail.com', 'violetteror66@gmail.com');
            $mail->addAddress($cemail);

            // Isi email
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP code is: <strong>$otp</strong>. Please use it to verify your account.";

            $mail->send();

            // Simpan email dan OTP di session
            $_SESSION['email'] = $cemail;
            $_SESSION['otp'] = $otp;

            $success_message = "OTP telah dikirim ke email Anda. Silakan cek inbox atau folder spam.";
            header("Location: change-pass.php");
            exit();
        } catch (Exception $e) {
            $error_message = "Gagal mengirim OTP. Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = 'Email tidak ditemukan di sistem.';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input E-mail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .login-form .form-control {
            border-radius: 30px;
            padding: 10px 20px;
        }
        .login-form .btn {
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .alert {
            margin-top: 15px;
            font-size: 14px;
        }
        .login-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .login-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Input E-mail</h2>

        <!-- Tampilkan pesan error atau sukses -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <!-- Form input email -->
        <form class="login-form" action="" method="POST">
            <div class="mb-3">
                <input type="email" name="cEmail" class="form-control" placeholder="Email" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Send OTP</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
