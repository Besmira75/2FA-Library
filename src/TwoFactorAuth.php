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
}
?>