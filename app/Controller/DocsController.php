<?php

namespace App\Controller;

use App\Core\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DocsController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->twig->display('docs/index.html.twig', ['docs']);
    }
}