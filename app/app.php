<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app new Silex\Application();


    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array (
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/clients", function() use ($app) {
        return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app){
        $stylists = Stylist::find($id);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylists, 'clients' => $stylists->getClients()));
    });

    $app->post("/stylists", function() use ($app) {
        $stylists = new Stylist($_POST['name']);
        $stylists->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $email = $_POST['email'];
        $stylists_id = $_POST['stylists_id'];
        $client = new Client($client_name, $email, $id = null, $stylists_id);
        $client->save();
        $stylists = Stylist::find($stylists_id);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylists, 'clients' => $stylists->getClients()));
    });

    $app->post("/delete_clients", function() use ($app){
        Client::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
