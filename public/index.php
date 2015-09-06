<?php
// bootstrap & init everything
include __DIR__.'/../bootstrap/init_exceptions.php';
include __DIR__.'/../bootstrap/start.php';
Dotenv::load(__DIR__.'/../');
include __DIR__.'/../bootstrap/functions.php';
include __DIR__.'/../bootstrap/db.php';

$app = new Acme\App\Application();

// load the routes file & search for matching route
include __DIR__.'/../routes.php';
$match = $router->match();

// are we calling a controller?
if (is_string($match['target']))
    list($controller, $method) = explode('@', $match['target']);

if ((isset($controller)) && ($controller != null) && (is_callable(array($controller, $method)))) {
    // controller
    $object = new $controller("text/html", $app);
    call_user_func_array(array($object, $method), array($match['params']));
} else if ($match && is_callable($match['target'])) {
    // closure
    call_user_func_array($match['target'], $match['params']);
} else {
    // nothing matches
    echo "Cannot find $controller -> $method";
    exit();
}
