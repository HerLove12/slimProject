<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

class AlunniController{
    function index(Request $request, Response $response, $args){
        $classe = new Classe();
        $alunni = $classe->getAlunni();

        $html = '<h1>Elenco degli alunni</h1>';
        foreach ($alunni as $alunno) {
            $alunno->toString();
        }

        $response->getBody()->write($html);
        return $response;
    }

    function indexByName(Request $request, Response $response, $args){
        $classe = new Classe();
        $nomeAlunno = $args['nome'];
    
        $x = $classe->cercaAlunno($nomeAlunno);

        if ($x !== null) {
            $html = '<h1>Dettagli dell\'alunno</h1>';
            $html .= '<p>' . $x->toString() . '</p>';
        } else {
            $html = '<h1>Alunno non presente</h1>';
        }

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    function indexJson(Request $request, Response $response, $args){
        $classe = new Classe();

        $response->getBody()->write(json_encode($classe->JsonSerialize()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    function indexJsonByName(Request $request, Response $response, $args){
        $classe = new Classe();
        $nomeAlunno = $args['nome'];

        $alunno = $classe->cercaAlunno($nomeAlunno);
        if ($alunno !== null) {
            $response->getBody()->write(json_encode($alunno));
        } else {
            $response->getBody()->write(json_encode(['message' => 'Alunno non presente'], 404));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
    
}