<?php 

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

$articles = require __DIR__.'/articles-data.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// affichage du rendu d'un template
echo $twig->render('articles.html.twig', [
    // transmission de données au template
    'articles' => $articles
]);

