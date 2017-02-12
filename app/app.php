<?php

require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/config/config.php';

use Http\Request;
use Http\Response;

date_default_timezone_set('UTC');

$debug = false;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);



$con  = new Dal\Connection('mysql:host='.$host.';port='.$port.';dbname='.$dbname, $username, $password);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    $app->redirect('/statuses');
});


/*
* Get all statuses
*/
$app->get('/statuses', function (Request $request) use ($app, $con) {
	$statusFinder = new \Dal\StatusFinder($con);

	if($request->guessBestFormat() == "text/html"){
		// Format html ?
		return new \Http\Response($app->render('statuses.php', $statusFinder->findAll($request->getParameters())));
	} else if($request->guessBestFormat() == "application/json"){
		// Format Json ?
		
		$jSonresponse = new \Http\JSONResponse(json_encode($statusFinder->findAll($request->getParameters())), 200);
		return $jSonresponse->getContent();
	} else {
		//Format invalide
		throw new Exception\HttpException(415, "Unsupported Media Type");
	}
	
	
});

/**
* Status by ID
*/
$app->get('/statuses/(\d+)', function (Request $request, Response $response = null,  $id) use ($app, $con) {

	$statusFinder = new \Dal\StatusFinder($con);
	$status = $statusFinder->findOneById($id);
	if ($status) {
		return $app->render('status.php', ["status" => $status]);
	} else {
		throw new Exception\HttpException(404, "Status not found"); 
	}
	
});

/*
* Add a status
*/
$app->post('/statuses', function (Request $request) use ($app, $con) {

	$statusMapper = new \Dal\StatusMapper($con);
	if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']) {
            $user_username = $_SESSION['user']->getUsername();
    } else {
            $user_username = null;
    }
	
	$message = $request->getParameter('message');
	
	$status = new Model\Status(null, $message, $user_username, date("Y-m-d H:i:s", time()));
	$statusMapper->persist($status);
	
	$app->redirect('/statuses', 204);

});

/*
* Delete a status
*/
$app->delete('/statuses/(\d+)', function (Request $request, Response $response = null, $id) use ($app, $con) {
	$statusMapper = new \Dal\StatusMapper($con);
	$statusFinder = new \Dal\StatusFinder($con);
	
	$status = $statusFinder->findOneById($id);
	$user_id = isset($_SESSION['user']) ? $_SESSION['user']->getUsername() : null;

	if($status){
		$statusMapper->remove($id);
		$app->redirect('/statuses', 204);
	}
	throw new Exception\HttpException(404, "Status not found");
	/* Plante sans l'auth stateless */
	/*if ($status && $user_id === $status->getUserUsername()){
		$statusMapper->remove($id);
		$app->redirect('/statuses', 204);
	} else if ($status && $user_id !== $status->getUserUsername()){
		$app->redirect('/statuses', 204);
	} else {
		throw new Exception\HttpException(404, "Status not found");
	}*/
});


/*
 * Sign In page
 */
$app->get('/signin', function (Request $request) use ($app){
	return $app->render('signin.php');
});

/*
 * Post Sign In
 */
$app->post('/signin', function (Request $request) use ($app, $con) {
	
	$userMapper = new \Dal\UserMapper($con);
    $userFinder = new \Dal\UserFinder($con);

    $username = $request->getParameter('username');
    $password = $request->getParameter('password');
    $passHash = password_hash($password, PASSWORD_BCRYPT);
    if($userFinder->findOneByUsername($username)){
    	return $app->render('signin.php', ['error' => "Nom d'utilisateur déjà prit"]);
    }

    $user = new Model\User(null, $username, $passHash);
    $userMapper->persist($user);

    $_SESSION['is_authenticated'] = true;
    $_SESSION['user'] = $userFinder->findOneByUsername($username);
    return $app->redirect('/statuses');
});

/*
 * Login page
 */
$app->get('/login', function () use ($app) {
	return $app->render('login.php');
});

/*
 * Post connection
 */
$app->post('/login', function (Request $request) use ($app, $con) {
	$userFinder = new \Dal\UserFinder($con);

	$username = $request->getParameter('user');
	$pass = $request->getParameter('password');
	$user = $userFinder->findOneByUsername($username);
	if ($user && password_verify($pass, $user->getPassword())) {
		$_SESSION['is_authenticated'] = true;
		$_SESSION['user'] = $user;
		return $app->redirect('/statuses');
	}
	if(isset($_SESSION['is_authenticated']) == true){
		return $app->render('login.php', ['error' => "Identifiants invalides"]);
	}
	throw new Exception\HttpException(404, "Login failed");
});

/*
 * Logout
 */
$app->get('/logout', function (Request $request) use ($app) {
	session_destroy();
	return $app->redirect('/');
});

/*
	Listener
*/
$app->addListener('process.before', function (Request $request) use ($app) {
	session_start();

	$allowed = [
		'/' => [Request::GET],
		'/login' => [Request::GET, Request::POST],
		'/logout' => [Request::GET, Request::POST],
		'/signin' => [Request::GET, Request::POST],
		'/statuses' => [Request::GET, Request::POST],
		'/statuses/(\d+)' => [Request::GET, Request::POST],
		
	];

	if (isset($_SESSION['is_authenticated']) && true === $_SESSION['is_authenticated']) {
        return;
    }

    foreach ($allowed as $uri => $methods) {
        if (preg_match(sprintf('#^%s$#', $uri), $request->getUri()) && in_array($request->getMethod(), $methods)) {
            return;
        }
    }

    switch ($request->guessBestFormat()) {
        case 'application/json':
            throw new Exception\HttpException(401);
    }

    return $app->redirect('/login');
});

return $app;