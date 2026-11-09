<?php
session_start(); require __DIR__.'/../config/config.php'; require __DIR__.'/../app/core/helpers.php';
spl_autoload_register(function($c){foreach([__DIR__.'/../app/core/',$__DIR__.'/../app/models/',$__DIR__.'/../app/controllers/'] as $d){if(is_file($d.$c.'.php'))require_once $d.$c.'.php';}});
$page=$_GET['page']??'products'; $action=$_GET['action']??'index';
try {
 if($page==='customer'){ $c=new CustomerController(); ($action==='store'?$c->store():$c->create());}
 else { $c=new ProductController(); if($action==='create')$c->create(); elseif($action==='store')$c->store(); else $c->index(); }
} catch(Throwable $e){http_response_code(500);echo 'Application error. Check database configuration and schema.';error_log($e->getMessage());}
