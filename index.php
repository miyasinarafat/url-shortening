<?php

const BASE_PATH = __DIR__.'/';

session_start();

require 'vendor/autoload.php';
require 'src/core/bootstrap.php';

use Core\{Request, Router, Session, ValidationException};

try {
    Router::load(BASE_PATH . 'src/routes/web.php')
        ->direct(Request::uri(), Request::method());
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);

    return redirect('/');
}

Session::unflash();
