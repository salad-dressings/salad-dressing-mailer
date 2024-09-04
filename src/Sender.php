<?php

namespace Salad\Dressing\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Salad\Core\Application;
use Salad\Dressing\Mailer\Models\Mailer;

class Sender
{
    protected $App;
    protected $mail;
    protected $mailer;
    protected $sender;

    public function __construct()
    {
        $this->App = Application::$app;
        $this->mailer = new Mailer;
        $this->setConfig();
    }

    function setConfig() {

        $stmt = $this->mailer->findById(1);

        $this->mail = new PHPMailer(true);
        
        $this->mail->isSMTP();
        $this->mail->Host = $stmt['host'] ?? "";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $stmt['username'] ?? "";
        $this->mail->Password = $stmt['password'] ?? "";
        $this->mail->SMTPSecure = $stmt['encryption'] ?? "";
        $this->mail->Port = $stmt['port'] ?? "";
        $this->mail->setFrom($stmt['address'] ?? "", $_ENV['SITE_TITLE'] ?? "");
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
