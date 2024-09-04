<?php
namespace Salad\Dressing\Mailer\Controllers;

use Salad\Core\Application;
use Salad\Core\Controller;
use Salad\Core\View;


class MailerController extends Controller
{
    protected $App;
    protected $view;

    public function __construct()
    {
        parent::__construct();   

        $this->App = Application::$app;
        $this->view = new View;
        $this->view->addViewPath( __DIR__ .'/../Views');
        $this->view->setPostLogin();
    }
    
    public function index()
    {
        $this->view->render('dressing_mailer/index');
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
