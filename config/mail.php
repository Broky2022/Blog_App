<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        
        // Server settings
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['MAIL_USERNAME'];
        $this->mail->Password = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $this->mail->Port = $_ENV['MAIL_PORT'];
        
        // Debug mode for development
        if ($_ENV['APP_DEBUG'] === 'true') {
            $this->mail->SMTPDebug = 2;
        }
        
        // Sender
        $this->mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
    }

    public function sendPasswordResetEmail($email, $token) {
        try {
            $this->mail->addAddress($email);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Reset Your Password';
            $this->mail->Body = "
                <h2>Password Reset Request</h2>
                <p>You have requested to reset your password. Click the link below to proceed:</p>
                <p><a href='{$_ENV['APP_URL']}/reset-password.php?token={$token}'>Reset Password</a></p>
                <p>This link will expire in 1 hour.</p>
                <p>If you did not request this password reset, please ignore this email.</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function sendTwoFactorCode($email, $code) {
        try {
            $this->mail->addAddress($email);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Two-Factor Authentication Code';
            $this->mail->Body = "
                <h2>Two-Factor Authentication</h2>
                <p>Your verification code is: <strong>{$code}</strong></p>
                <p>This code will expire in 5 minutes.</p>
                <p>If you did not request this code, please secure your account immediately.</p>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }
} 