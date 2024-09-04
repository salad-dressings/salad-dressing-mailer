<?php
namespace Salad\Dressing\Mailer\Controllers;

use Salad\Core\Application;
use Salad\Core\Controller;
use Salad\Core\View;

use Salad\Dressing\Mailer\Models\Mailer;
use Salad\Dressing\Mailer\Sender;
use App\Models\User;

class MailerController extends Controller
{
    protected $App;
    protected $view;
    protected $user;
    protected $mailer;
    protected $sender;

    public function __construct()
    {
        parent::__construct();   

        $this->App = Application::$app;
        $this->view = new View;
        $this->user = new User;
        $this->mailer = new Mailer;
        $this->view->addViewPath( __DIR__ .'/../Views');
        $this->view->setPostLogin();

    }
    
    public function index()
    {
        $this->view->render('dressing_mailer/index', [
            "details" => $this->mailer->findById(1)
        ]);
    }
    
    public function submit()
    {
        $smtp = $this->App->request->getBody('smtpServer');
        $port = $this->App->request->getBody('port');
        $username = $this->App->request->getBody('username');
        $password = $this->App->request->getBody('password');
        $encryption = $this->App->request->getBody('encryption');
        $senderEmail = $this->App->request->getBody('senderEmail'); 


        if(
            trim($smtp) == "" || 
            trim($port) == "" || 
            trim($username) == "" || 
            trim($password) == "" || 
            trim($encryption) == "" || 
            trim($senderEmail) == ""
        ){
            $this->App->session->setFlash("notification_warning", "Fill all the required fields.");
            $this->App->response->redirect("/admin/mailer");
        }
        
        $stmt = $this->mailer->findById(1);
        if(!$stmt){
            $result = $this->mailer->createConfig([
                ":host" => $smtp,
                ":username" => $username,
                ":password" => $password,
                ":encryption" => $encryption,
                ":port" => $port,
                ":address" => $senderEmail
            ]);
            $this->App->session->setFlash("notification_success", "Mailer configuration saved.");
            $this->App->response->redirect("/admin/mailer");
        } else {
            $result = $this->mailer->updateConfig([
                ":host" => $smtp,
                ":username" => $username,
                ":password" => $password,
                ":encryption" => $encryption,
                ":port" => $port,
                ":address" => $senderEmail
            ]);
            $this->App->session->setFlash("notification_success", "Mailer configuration saved.");
            $this->App->response->redirect("/admin/mailer");
        }

    }

      
    public function test()
    {
        $this->sender = new Sender;
        $userId = $this->App->session->get('user_id');
        $stmt = $this->user->findById($userId);
        $this->sender->addRecipient($stmt['email']);
        $this->sender->setSubject("SaldaStack Email Test");
        $this->sender->setBody("This is a test email to confirm that your Salad Dressing Mailer configuration is working properly.");
        $sent = $this->sender->send();

        if($sent){
            $this->App->session->setFlash("notification_success", "Test mail sent.");
        } else {
            $this->App->session->setFlash("notification_warning", "Sending failed.");

        }
        $this->App->response->redirect("/admin/mailer");
        
    }
    
}
