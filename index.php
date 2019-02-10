<?php
require 'vendor/autoload.php';

$config = include './src/config.php';
$app = new \Slim\App(["settings" => $config]);


/// set up database 
$container = $app->getContainer();
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
/// end set up database


/// define routes  
$app->get('/', function ($request) {
    $isDev = $request->getQueryParam('dev') !== NULL;
    include './src/views/main.php';
});

$app->get('/search_rhyme/{keyword}', function ($request, $response, array $args) use ($app) {
    $keyword = $args['keyword'];

    /// load on demands
    $app->getContainer()->get('db');
    $list = Word::where('word', 'LIKE', "%{$keyword}")->get();
    return $response->withJson($list->toArray()); 
});

$app->post('/search_needle', function($request,  $response) use ($app) {

    $body = $request->getParsedBody();
    $chars = isset($body['chars']) ? $body['chars'] : [];

    if(empty($chars)) {
        return $response->withJson([]); 
    }

    $chars = array_map(function($char){
        // check in A, a
        $char = strtolower($char);
        $ch_code = ord($char);
        if($char === '' || $ch_code < ord('a') || $ch_code > ord('z')) {
            return '_';
        }
        return $char;
    },  $chars);

    $condition = implode('', $chars);

    /// load on demands
    $app->getContainer()->get('db');


    $list = Word::where('word', 'LIKE', $condition)->get();
    return $response->withJson($list->toArray()); 
});

$app->run();
