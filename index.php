<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once 'Classe.php';
require_once 'Alunno.php';

$app = AppFactory::create();

$container = $app->getContainer;

$container->set('Classe', function () {
    $classe = new Classe();
    $classe->aggiungiAlunno(new Alunno("mario", "rossi", 15));
    $classe->aggiungiAlunno(new Alunno("giulia", "ianchi", 16));
    $classe->aggiungiAlunno(new Alunno("luca", "verdi", 15));
    return $classe;
});


$app->get('/', function (Request $request, Response $response, $args) {
    var_dump($app->$container);
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/alunni', function (Request $request, Response $response, $args) {
    $classe = $container->get('Classe');

    $alunni = $classe->getAlunni();

    $html = '<h1>Elenco degli alunni</h1>';
    foreach ($alunni as $alunno) {
        $alunno->toString();
    }

    $response->getBody()->write($html);
    return $response;
});

$app->get('/alunni/{nome}', function (Request $request, Response $response, $args) {
    $classe = $container->get('Classe');

    $nomeAlunno = $args['nome'];
    
    $x = $classe->cercaAlunno($nomeAlunno);

    if ($x !== null) {
        $html = '<h1>Dettagli dell\'alunno</h1>';
        $html .= '<p>' . $x->toString() . '</p>';
    } else {
        $html = '<h1>Alunno non presente</h1>';
    }

    // Restituzione della risposta HTML
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/api/alunni', function (Request $request, Response $response, $args) {
    $classe = $container->get('Classe');
    // Restituzione dell'oggetto Classe serializzato in JSON
    $response->getBody()->write(json_encode($classe->JsonSerialize()));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/alunni/{nome}', function (Request $request, Response $response, $args) {
    $classe = $container->get('Classe');

    $alunno = $classe->cercaAlunno($nomeAlunno);

    if ($alunno !== null) {
        $response->getBody()->write(json_encode($alunno));
    } else {
        $response->getBody()->write(json_encode(['message' => 'Alunno non presente'], 404));
    }

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();