<?php
session_start();
require_once "config.php"; // Koneksi ke database
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email']; 
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $input_otp = htmlspecialchars(trim($_POST['otp'])); 

        $stmt = $conn->prepare("SELECT otp FROM tbuser WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_otp);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if ($input_otp == $db_otp) {
                $update_stmt = $conn->prepare("UPDATE tbuser SET status = 'used' WHERE email = ?");
                $update_stmt->bind_param("s", $email);
                $update_stmt->execute();

                $success_message = "OTP berhasil diverifikasi! Silakan ganti password Anda.";

                if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                    $new_password = htmlspecialchars(trim($_POST['new_password']));
                    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

                    if ($new_password === $confirm_password) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $update_pass_stmt = $conn->prepare("UPDATE tbuser SET password = ? WHERE email = ?");
                        $update_pass_stmt->bind_param("ss", $hashed_password, $email);
                        $update_pass_stmt->execute();

                        header("Location: index.php");
                        exit();
                    } else {
                        $error_message = "Password baru dan konfirmasi password tidak cocok.";
                    }
                }
            } else {
                $error_message = "OTP yang dimasukkan salah. Silakan coba lagi.";
            }
        } else {
            $error_message = "Data tidak ditemukan. Silakan ulangi proses.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h2 class="text-center">Change Password</h2>

        <!-- Pesan error -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <!-- Pesan sukses -->
        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <!-- Form input OTP dan password baru -->
        <form action="" method="POST">
    <div class="mb-3">
        <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP" required>
    </div>
    <div class="mb-3">
        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password" required disabled>
    </div>
    <div class="mb-3">
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required disabled>
    </div>
    <button type="submit" class="btn btn-primary w-100">Change Password</button>
</form>

<script>
    const otpInput = document.getElementById('otp');
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    // Fungsi untuk enable textbox password setelah OTP diinput
    otpInput.addEventListener('input', function() {
        if (otpInput.value.trim() !== '') {
            newPasswordInput.disabled = false;
        } else {
            newPasswordInput.disabled = true;
            confirmPasswordInput.disabled = true;
            newPasswordInput.value = '';
            confirmPasswordInput.value = '';
        }
    });

    // Fungsi untuk enable textbox konfirmasi password setelah password diinput
    newPasswordInput.addEventListener('input', function() {
        if (newPasswordInput.value.trim() !== '') {
            confirmPasswordInput.disabled = false;
        } else {
            confirmPasswordInput.disabled = true;
            confirmPasswordInput.value = '';
        }
    });
</script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
