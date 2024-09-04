<?php

namespace Salad\Dressing\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Salad\Core\Application;
use Salad\Dressing\Mailer\Models\Mailer;

class Send
{
    protected $App;
    protected $mail;

    public function __construct()
    {
        $this->App = Application::$app;
        // $this->setConfig();
    }

    function setConfig() {

        $stmt = $this->mailer->findById(1);
        $this->mail = new PHPMailer(true);
        
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.yourdomain.com'; // Set SMTP server
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'your_email@yourdomain.com'; // SMTP username
        $this->mail->Password = 'your_password'; // SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        
        $this->mail->setFrom('no-reply@yourdomain.com', 'Your App Name');
    }

    public function addRecipient($email, $name = '')
    {
        $this->mail->addAddress($email, $name);
    }

    public function setSubject($subject)
    {
        $this->mail->Subject = $subject;
    }

    public function setBody($body, $isHTML = false)
    {
        if ($isHTML) {
            $this->mail->isHTML(true);
        }
        $this->mail->Body = $body;
    }

    public function addAttachment($filePath, $fileName = '')
    {
        $this->mail->addAttachment($filePath, $fileName);
    }

    public function send()
    {
        try {
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}
