<?php

namespace TwoFA;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \DateTime;

class TwoFactorAuth
{
    private $mailer;
    private $fromEmail;

    public function __construct($smtpHost, $smtpPort, $smtpUser, $smtpPass, $fromEmail)
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $smtpHost;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $smtpUser;
        $this->mailer->Password = $smtpPass;
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = $smtpPort;
        $this->fromEmail = $fromEmail;
    }

    public function sendEmail($toEmail, $subject, $body)
    {
        try {
            $this->mailer->setFrom($this->fromEmail);
            $this->mailer->addAddress($toEmail);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function generateCode()
    {
        return rand(100000, 999999);
    }

    public function send2FACode($toEmail, $code)
    {
        $subject = "Your 2FA Code";
        $body = "Your 2FA code is $code. It will expire in 5 minutes.";
        return $this->sendEmail($toEmail, $subject, $body);
    }

    public function verifyCode($storedCode, $inputCode, $expiryTime)
    {
        $currentTime = new DateTime();
        if ($currentTime < $expiryTime && $storedCode === $inputCode) {
            return true;
        }
        return false;
    }
}
?>