<?php
require_once 'core/init.php';

$usuario = new Usuario();
$usuario->logout();
Redirect::to('index.php');