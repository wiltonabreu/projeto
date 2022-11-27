<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Wap\Page;
use \Wap\PageAdmin;
use \Wap\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

//ROTA ADMIN
$app->get('/admin/', function() {
    User::verifyLogin();
	$page = new PageAdmin();

	$page->setTpl("index");

});

//Rota para acessar a pagina de login
$app->get('/admin/login', function() {
    
    $page = new PageAdmin([
        "header"=>false,
		"footer"=>false
    ]);

	$page->setTpl("login");

});

//Rota para receber dados da pagina de login
$app->post('/admin/login', function() {

    User::login($_POST["login"], $_POST["password"]);

    header("Location: /admin");

    exit;
    
});

$app->get('/admin/logout', function() {
    
    User::logout();
    header("Location: /admin");
    exit;	

});


$app->run();

 ?>