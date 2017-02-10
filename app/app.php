<?php
// php -S localhost:8000 -d error_reporti=-1 -d display_errors=On -t ./web
require __DIR__ . '/../vendor/autoload.php';
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
$app->get('/', function (\Http\Request $request, \Http\Response $response = null) use ($app) {

    return $app->render('index.php', array());
});


/*
* Get all statuses
*/
$app->get('/statuses', function (\Http\Request $request, \Http\Response $response = null) use ($app, $con) {
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
$app->get('/statuses/(\d+)', function (\Http\Request $request, \Http\Response $response = null, $id) use ($app) {
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
* Add status
*/
$app->post('/statuses', function (\Http\Request $request, \Http\Response $response = null) use ($app) {

	$sf = new \Model\StatusFinder();

	$username = $request->getParameter('username');
	$message = $request->getParameter('message');

	
	$app->redirect('/statuses', 204);

});

/*
* Delete status
*/
$app->delete('/statuses/(\d+)', function (\Http\Request $request, \Http\Response $response = null, $id) use ($app) {
	$jm = new \Model\JsonModificator();
	$status = $jf->findOneById($id);
	if ($jm->deleteStatus($id) != null) {

		$jm->deleteStatus($id);
		$app->redirect('/statuses', 204);
	} else {
		throw new Exception\HttpException(404, "Status not found"); 
	}
});


return $app;
