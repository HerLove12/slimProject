<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once 'controllers/SiteController.php';
require_once 'controllers/AlunniController.php';
require_once 'Classe.php';
require_once 'Alunno.php';

$app = AppFactory::create();

$app->get('/','SiteController:index');
$app->get('/alunni','AlunniController:index');
$app->get('/alunni/{nome}','AlunniController:indexByName');
$app->get('/api/alunni','AlunniController:indexJson');
$app->get('/api/alunni/{nome}','AlunniController:indexJsonByName');

$app->run();