<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Checkout.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = '';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(),
        array('twig.path' => __DIR__.'/../views'
    ));

    // Enable HTTP methods PATCH and DELETE
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // Landing page-- allow user to choose Librarian or Patron mode
    // if patron, enter your name. if librarian, also enter your name just for the record! #nsa
    // patron id will be held in a Cookie
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    // Librarian mode initializing... Book list and functions
    // Show list of all books, allow librarian to add copies of any book via number box on side
    // Give librarian option to add a new book
    // Give librarian option to search books by title, author, or overdue (all separate forms & different urls).
    // Search uses %like% to find similar matches
    // Includes link to author page
    // [R]
    $app->get("/lib/books", function() use ($app) {
        // check for search query, use it to filter all books list on main books page
    });

    // [C] add new book
    $app->post("/lib/books", function() use ($app) {

    });

    // [D] delete all books
    $app->delete("/lib/books", function() use ($app) {

    });

    //no update route on the books-wide level. what would that even mean?



    // Individual book CRUD........
    // [R] display book and give option to update it or delete it
    $app->get("/lib/book/{id}", function($id) use ($app) {

    });

    // [U] add copies of a book
    $app->patch("/lib/book/{id}", function($id) use ($app) {

    });

    // [D] delete this book
    $app->delete("/lib/book/{id}", function($id) use ($app) {

    });





    // Individual author CRUD......
    // [R] author landing page. display this author
    $app->get("/lib/author/{id}", function($id) use ($app) {

    });

    // [C] add an author
    $app->post("/lib/author/{id}", function($id) use ($app) {

    });

    // [U] update author
    $app->patch("/lib/author/{id}", function($id) use ($app) {

    });

    // [D] delete author
    $app->delete("/lib/author/{id}", function($id) use ($app) {

    });




    // [R] Librarian can view all current checkouts and patron information
    $app->get("/lib/checkouts", function() use ($app) {

    });







    // Welcome to library patron experience
    // Landing page - show all books, let patron search by author, title,
    // all librarian URLS have /lib/ prefix. all patron URLS are naked.
    // display links to current checkouts and checkout history
    // [R]
    $app->get("/books", function() use ($app) {
        // check for search query, use it to filter all books list on main books page
    });

    // [R] display search results from form on get /books if patron has searched
    $app->post("/books", function() use ($app) {

    });


    // individual book methods for a patron
    // [R] display book info, #copies, link to check out a copy if available
    $app->get("/book/{id}", function($id) use ($app) {

    });

    // [C] checkout a book
    $app->post("/book/{id}/checkout", function($id) use ($app) {

    });

    // [R] Show Patron's current checkout
    $app->get("/current_checkouts", function() use ($app) {

    });

    // [R] Show Patron's checkout history
    $app->get("/checkout_history", function() use ($app) {

    });




    return $app;

?>
