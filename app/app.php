<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

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

    $app->post("/deleted", function() use ($app){
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app){
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylists.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/client/{id}", function($id) use ($app){
        $client = Client::find($id);
        return $app['twig']->render("clients.html.twig", array('client' => $client));
    });

    $app->delete("/client/{id}/deleted", function($id) use ($app){
        $client = Client::find($id);
        $stylist = Stylist::find($client->getStylistId());
        $client->delete();
        return $app['twig']->render("stylists.html.twig", array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->patch("/client/{id}/updated", function($id) use ($app){
        $new_email = $_POST['new_email'];
        $client = Client::find($id);
        $stylist = Stylist::find($client->getStylistId());
        $client->updateEmail($new_email);
        return $app['twig']->render("stylists.html.twig", array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $email = $_POST['email'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($client_name, $email, $id = null, $stylist_id);
        $client->save();

        // var_dump($_POST['stylist_id']);
        $stylist = Stylist::find($stylist_id);
        // var_dump($stylist);
        $clients = $stylist->getClients();
        // var_dump($clients);

        return $app['twig']->render('stylists.html.twig', array('stylist' => $stylist, 'clients' => $clients));
    });

    $app->post("/delete_clients", function() use ($app){
        Client::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    // $app->delete("/stylist/delete_clients/{id}/", function($id) use ($app) {
    //     $stylist = Stylist::find($id);
    //     $stylist->delete();
    //     return $app['twig']->render('stylists.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    // });

    return $app;
?>
