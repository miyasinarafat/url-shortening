 <?php

$router->get('', 'ShortLinkController@index');
$router->get('/r/{hash}', 'ShortLinkController@redirect');
$router->post('short-links', 'ShortLinkController@store');
