<?php
namespace App\Controller;

use App\Core\Controller;
use App\Model\PostsModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->twig->display('main/index.html.twig');
    }

}