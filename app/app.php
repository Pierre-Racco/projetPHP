<?php
// php -S localhost:8000 -d error_reporti=-1 -d display_errors=On -t ./web
require __DIR__ . '/../vendor/autoload.php';
use Http\Request;
use Http\Response;
include __DIR__ . '/config/config.php';
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);
// Config
$debug = false;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);
echo $host.$dbname.$charset.$username.$password;


//$con  = new \Model\Connection('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$con  = new \Model\Connection('sqlite:/tmp/foo.db');
$mapper = new \Model\StatusMapper($con);


/**
 * Index
 */
$app->get('/', function (Request $request, Response $response = null) use ($app) {

    $app->render('index.php');
});


/*
* Get all statuses
*/
$app->get('/statuses', function (Request $request, Response $response = null) use ($app, $con) {
	$sf = new \Model\StatusFinder($con);
	
	if($request->guessBestFormat() == "text/html; charset=UTF-8"){
		// Format html ?

		
		return $app->render('statuses.php', $sf->findAll());
	} else if($request->guessBestFormat() == "application/json"){
		// Format Json ?
		
		$jSonresponse = new \Http\JSONResponse(json_encode($sf->findAll()), 200);
		return $jSonresponse->getContent();
	} else {
		//Format invalide
		throw new Exception\HttpException(415, "Unsupported Media Type");
	}
	
	
});

/**
* Status by ID
*/
$app->get('/statuses/(\d+)', function (Request $request, Response $response = null, $id) use ($app) {
	$jf = new \Model\JsonFinder();
	// $array = array();
	$status = $jf->findOneById($id);


	if ($status != null) {
		return $app->render('status.php', $status);
	} else {
		throw new Exception\HttpException(404, "Status not found"); 
	}
	
});

/*
* Add a status
*/
$app->post('/statuses', function (Request $request, Response $response = null) use ($app) {

	$mapper = new Model\StatusMapper($con);

	$username = $request->getParameter('username');
	$message = $request->getParameter('message');
	
	$status = new Model\Status($message, $username);
	$mapper->persist($status);
	$app->redirect('/statuses', 204);

});

/*
* Delete a status
*/
$app->delete('/statuses/(\d+)', function (Request $request, Response $response = null, $id) use ($app) {
	$jm = new \Model\JsonModificator();
	$status = $jf->findOneById($id);
	if ($jm->deleteStatus($id) != null) {

		$jm->deleteStatus($id);
		$app->redirect('/statuses', 204);
	} else {
		throw new Exception\HttpException(404, "Status not found"); 
	}
});


/*
 * Sign In page
 */
$app->get('/signin', function (Request $request) use ($app)
	return $app->render('signin.php');
);

/*
 * Post Sign In
 */
$app->post('/signin', function (Request $request) use ($app, $con) {
	/*
		TODO
		check si username déjà présent dans base
		ajout dans base
	*/ 
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
	$user = $request->getParameter('user');
	$pass = $request->getParameter('password');

	// debut
	//	|	à enlever avec ton mapper 
	//	v
	if ($user === 'admin' && $pass === 'admin') {
		$_SESSION['is_authenticated'] = true;
		return $app->redirect('/');
	}
	// fin

	return $app->render('login.php', ['user' => $user]);
});

/*
 * Logout
 */
$app->get('/logout', function (Request $request) use ($app) {
	session_destroy();
	return $app->render('/');
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
        case 'json':
            throw new Exception\HttpException(401);
    }

    return $app->redirect('/login');
});

return $app;