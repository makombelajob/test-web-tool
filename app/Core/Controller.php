<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private FilesystemLoader $loader;

    protected Environment $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/templates');
        $this->twig = new Environment($this->loader);

    }

    public function render(string $view, array $data = [], string $template = 'default'): void
    {
        // On extrait les données de $data
        extract($data);

        // On démarre le buffer de sortie
        ob_start();
        // A partir d'ici, toute sortie (echo par exemple) est conservée en mémoire

        // On charge la vue
        require_once ROOT . '/View/' . $view . '.php';

        // On transfère le buffer dans $content
        $content = ob_get_clean();

        // On charge le template
        require_once ROOT . '/View/' . $template . '.php';
    }

    public function isConnected(): bool
    {
        if(!empty($_SESSION['user'])){
            return true;
        }
        return false;
    }
}