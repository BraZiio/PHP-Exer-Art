<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

// valeurs par défaut du formulaire
$formData = [
    'name' => '',
    'price' => '',
    'quantity' => '',
    'description' => '',
];

// le tableau contenant la liste des erreurs
$errors = [];
// le tableau contenant les messages d'erreur
$messages = [];

// vérification de présence de données envoyées par l'utilisateur
if ($_POST) {
    // remplacement des valeurs par défaut par les valeurs envoyées par l'utilisateur
    if (isset($_POST['name'])) {
        $formData['name'] = $_POST['name'];
    }
    if (isset($_POST['price'])) {
        $formData['price'] = $_POST['price'];
    }
    if (isset($_POST['quantity'])) {
        $formData['quantity'] = $_POST['quantity'];
    }
    if (isset($_POST['description'])) {
        $formData['description'] = $_POST['description'];
    }

    // validation des données
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['form'] = true;
        $messages['form'] = 'nom incorrect';
    } elseif (strlen($_POST['name']) < 2 || strlen($_POST['name']) > 100) {
        $errors['form'] = true;
        $messages['form'] = 'nom incorrect';
    }elseif (is_numeric($_POST['name'])) {
        $errors['form'] = true;
        $messages['form'] = 'mettez des caractères';
    }

    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $errors['form'] = true;
        $messages['form'] = 'prix incorrect';
    } elseif (!is_numeric($_POST['price'])) {
        $errors['form'] = true;
        $messages['form'] = 'prix incorrect';
    }

    if (
        strpos($_POST['description'], '<')
        || strpos($_POST['description'], '>')
    ) {
        // la description contient un caractère interdit < ou >
        $errors['description'] = true;
        $messages['form'] = 'Symboles < ou > non accepter';
    }

    if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
        $errors['quantity'] = true;
        $messages['form'] = 'quantité incorrect';
    } 
    if (
        is_numeric($_POST['quantity'])
        && ($_POST['quantity'] - floor($_POST['quantity'])) == 0
    ){
        // la variable contient un nombre entier
    } 
    elseif (!is_numeric($_POST['quantity'])) {
        $errors['quantity'] = true;
        $messages['form'] = 'mettez des chiffres';
    }
    else {
        // la variable ne contient pas de nombre entier
        $errors['quantity'] = true;
        $messages['form'] = 'Pas de virgule';
    }

    // on vérifie s'il y a des erreurs
    if (!$errors) {
        // il n'y a pas d'erreurs

        // démarrage de la session
        session_start();

        dump($formData);
        // redirection de l'utilisateur vers la page articles
         $url = 'articles.php';
        header("Location: {$url}", true, 302);
        exit();
    }
}

// affichage du rendu d'un template
echo $twig->render('article-new.html.twig', [
    // transmission de données au template
    'formData' => $formData,
    'errors' => $errors,
    'messages' => $messages,
]);
