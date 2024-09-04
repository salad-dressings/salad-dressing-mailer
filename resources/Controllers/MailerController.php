<?php
namespace Salad\Dressing\Mailer\Controller;

use Salad\Core\Application;
use Salad\Core\Controller;

class MailerController extends Controller
{
    protected $App;
    public function __construct()
    {
        parent::__construct();   
        $this->App = Application::$app;
        $userId = $this->App->session->get('user_id');
        if(!$userId){
            $this->App->response->redirect("/admin/login");
        }
    }
    
    public function index()
    {
        $this->render('admin/dressing_mailer/index');
    }
    
    public function submit()
    {
        $smtpServer = $this->App->request->getBody('smtpServer');
        $port = $this->App->request->getBody('port');
        $username = $this->App->request->getBody('username');
        $password = $this->App->request->getBody('password');
        $encryption = $this->App->request->getBody('encryption');
        $senderEmail = $this->App->request->getBody('senderEmail');
    }
}
