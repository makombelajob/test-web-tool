<?php
session_start();
use App\Core\Main;

// On définit une constante qui définit le dossier racine
define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

// On instancie Main
$app = new Main();

// On démarre l'application
$app->start();