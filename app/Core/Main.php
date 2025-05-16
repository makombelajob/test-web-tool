<?php
namespace App\Core;

use App\Controller\MainController;

/**
 * Routeur
 */
class Main
{
    public function start(): void
    {
        // On récupère l'URL
        $uri = $_SERVER['REQUEST_URI'];
        
        // On vérifie si elle n'est pas vide et si elle se termine par un /
        if(!empty($uri) && $uri != '/' && $uri[-1] === '/'){
            // Dans ce cas on enlève le / de fin
            $uri = substr($uri, 0, -1);
            
            // On envoie une redirection permanente
            http_response_code(301);

            // On redirige vers la bonne url sans le /
            header('Location: ' . $uri);
            exit;
        }

        // On récupère et on découpe le paramètre p en méthode GET
        $params = explode('/', $_GET['p']);

        // Si on n'a pas de paramètres
        if($params[0] === ''){
            // On instancie le contrôleur principal (MainController)
            $controller = new MainController();

            // On appelle la méthode index
            $controller->index();
        }else{
            // Le 1er paramètre sera le nom du contrôleur (passer la 1ère lettre en majuscule et ajouter "Controller" après) en "dépilant" les paramètres
            $controllerName = ucfirst(array_shift($params));

            // Le 2ème paramètre (s'il existe) sera le nom de la méthode
            $action = isset($params[0]) ? strtolower(array_shift($params)) : 'index';

            // On écrit le nom complet du contrôleur (avec namespace)
            $controllerName = '\\App\\Controller\\' . $controllerName . 'Controller';
            //$controllerName = "\\App\\Controller\\{$controllerName}Controller";

            // On instancie le contrôleur
            $controller = new $controllerName();

            // On vérifie si la méthode existe dans le contrôleur identifié
            if(method_exists($controller, $action)){
                // La méthode existe
                // On vérifie si un 3ème paramètre existe
                if(isset($params[0])){
                    // On appelle la méthode en passant $params en paramètre 
                    $controller->$action(...$params);
                }else{
                    // On appelle la méthode
                    $controller->$action();
                }
            }else{
                // La méthode n'existe pas
                http_response_code(404);
                echo 'La page recherchée est introuvable';
            }
        }
    }
}