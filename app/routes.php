<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Kittiefight\Ethie;
use Kittiefight\MetadataGenerator;
use Kittiefight\KittiefightException;


//Access-Control-Allow-Origin: *

$app->redirect('/', 'https://kittiefight.io', 302);

$app->get('/metadata/contract.json', function (Request $request, Response $response, $args) {
    $generator = $this->get('MetadataGenerator');
    $data = $generator->getContractLevelMetadata();
    $response->getBody()->write(json_encode($data));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Origin', '*');
});

$app->get('/metadata/{id:\d+}.json', function (Request $request, Response $response, $args) {
    //$data = array('id'=>$args['id']);
    $generator = $this->get('MetadataGenerator');
    $tokenId = intval($args['id']);
    try{
        $data = $generator->getMetadata($tokenId);
    }catch(KittiefightException $ex) {
        $data = [
            'error'=> $ex->getMessage()
        ];
        if($ex->getCode() == KittiefightException::ERR_NOT_FOUND){
            $response = $response->withStatus(404);
        }else{
            $response = $response->withStatus(500);
        }
    }catch(Exception $ex) {
        $data = [
            'error'=> 'Unexpected server error'
        ];
        $response = $response->withStatus(500);
    }

    $response->getBody()->write(json_encode($data));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Origin', '*');
});


// Not-Found Handling
$errorMiddleware->setErrorHandler(Slim\Exception\HttpNotFoundException::class, 
    function (Request $request, \Throwable $exception, bool $displayErrorDetails, bool $logErrors,bool $logErrorDetails) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    return $response->withStatus(404);
    //return $response->withHeader('Location', 'https://kittiefight.io');
});



