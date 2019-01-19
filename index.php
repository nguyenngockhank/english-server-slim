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

$app->run();
