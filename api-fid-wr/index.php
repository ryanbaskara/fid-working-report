<?php
	require_once 'vendor/autoload.php';
	require_once 'lib/mysql.php';
	require_once 'lib/mobile-apps.php';

	$app = new Slim\App();

	$app->get('/', function ($request, $response, $args) {
	    $response->write("API Connected");
	    return $response;
	});

	//---mobile apps user---//
	$app->post('/auth', function ($request, $response, $args) {
		$response->write(auth());
		return $response;
	});

	$app->post('/attended-day', function ($request, $response, $args) {
		$response->write(post_attended_day());
		return $response;
	});

	$app->post('/attended-month', function ($request, $response, $args) {
		$response->write(post_attended_month());
		return $response;
	});

	$app->get('/data-month', function ($request, $response, $args) {
	    $response->write(get_data_month());
	    return $response;
	});

	$app->get('/view-month-attended-form', function ($request, $response, $args) {
	    $response->write(view_month_attended_form());
	    return $response;
	});

	$app->post('/delete-attended-day', function ($request, $response, $args) {
		$response->write(delete_attended_day());
		return $response;
	});

	$app->get('/select-month', function ($request, $response, $args) {
	    $response->write(select_month());
	    return $response;
	});

	$app->get('/notification', function ($request, $response, $args) {
	    $response->write(notification());
	    return $response;
	});
	$app->run();