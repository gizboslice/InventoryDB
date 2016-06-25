<?php

// This line will be on any API PHP file, it loads in
// properties about the API class that exist in the
// API.class.php file.  This is important for making the TestAPI
// class below functional -> it inherits properties/methods from the API class
// and then has its own (such as the example() function below ).
require_once 'API.class.php';


// This is where we declare our new API class.  It HAS to extend the
// API class so that any request to TestAPI has the processing
// functionality available.
class TestAPI extends API {

    /**
    * Property: query
    * Holds the query parameters at the end of the request URI.
    * eg: /<endpoint>/<verb>/<arg0>/?query0=value0&query1=value1
    */
    protected $query;

    /**
    * Property: user
    * Used to hold information about the authenticated API user.
    */
    protected $User;
    // I wouldn't worry too much about the user portion at the moment, this is where we
    // would authenticate a user to use our API.  If we don't set something like this up,
    // anyone in the world can consistently make requests to the API without an easy way
    // to automatically blame them for it and possibly block their requests.


    // Every class (should) have a construct function, it is what gets called when someone declares
    // a new instance of your class.  For example, in code that would look like $testAPI = new TestAPI();.
    // This would run the __construct function in the TestAPI class, and return the instance to the $testAPI
    // variable.
    public function __construct( $request, $origin, $query ) {

        // Conveniently, we have already set up the construct function in the main API class
        // (a reminder that is located at API.class.php), so we can just call that function instead,
        // without having to duplicate the code here!  By calling parent::__construct, we are calling
        // the __construct function on the "parent" class, which is what our class "extends".  Because
        // our class "extends" the API class, that will be the parent.
        parent::__construct( $request );

        parse_str( $query, $this->query );

        // DONT WORRY ABOUT THIS BELOW - MORE USER AUTHENTICATION
        // Example of Token Implementation
        // $APIKey = new Models\APIKey();
        // $User = new Models\User();

        // if (!array_key_exists('apiKey', $this->request)) {
        //     throw new Exception('No API Key provided');
        // } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
        //     throw new Exception('Invalid API Key');
        // } else if (array_key_exists('token', $this->request) &&
        //      !$User->get('token', $this->request['token'])) {

        //     throw new Exception('Invalid User Token');
        // }

        // $this->User = $User;

    }

    // So this is where it gets fun!  Everything else has been set up for us, we now just need to set up
    // "endpoints" for the API.  Endpoints are a web service that can be accessed by URL to retrieve,
    // create, delete, and update information in a database.  This is the meat of the API, and our job
    // is to create all of the endpoints necessary to get information on the front end of the site.
    // Below is a simple example to demonstrate the basics of this concept.

    // Due to the way that our API is set up, creating a function in a class that extends the API class
    // (so this TestAPI class) called "example()" will actually create an endpoint for the API.  This endpoint
    // can be accessed by URL at "http://inventorydb.digitalmediauconn.org/api/v1/example" (when your api files 
    // are live on this server of course, which I have set up).  What that means is that any HTTP request
    // to that URL will invoke the "example()" function below, based on which HTTP method they have
    // requested.  By typing that endpoint into your browser, you perform a GET request to the example() function,
    // and a message should be returned.
    /**
    * Private Function: example
    * An example concrete endpoint for the InventoryAPI
    */
    protected function example( $args ) {

        // You should read about HTTP methods before trying to dive into working on the API, but below is an
        // example of the POST HTTP method.  As GET is used for retrieving information from the database (generally),
        // POST can be used to create rows and insert them into the database.  Generally when a HTTP request is made
        // to a PHP backend it will contain several query variables at the end of the URL, usually denoted by 
        // "?key=value&key2=value2". Our parent API class will handle these and stick them in the $query variable.
        // By making a GET request to the /api/v1/example?variable=value endpoint, we should see our query variables be available.
        // In a POST request, with our query variables set,
        // we can use them to insert information into our database.
        if ( $this->method == 'GET' ) {

            // Try this out!  Make a GET request to "http://inventorydb.digitalmediauconn.org/api/v1/example?name=YourName".
            // You can do this by simply typing it in your browser, although to test for other HTTP Methods (like POST and PUT),
            // you might have to download some third party extension to make this easy.
            // You should see a Welcome message with the value you passed as YourName attached to it, made possible by the code below.
            $output = "Welcome " . $this->query['hello'];
            return $output;

        } 


        else if ( $this->method == 'POST' ) {

            ob_start();
            var_dump( $this->query );
            $output = ob_get_clean();

            return $output;

        }
    }

}