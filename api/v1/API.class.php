<?php

abstract class API
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed.
     * eg: /<endpoint>/<verb>/<arg0>/<arg1> or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct($request) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->args = explode('/', rtrim( $request, '/' ));
        $this->endpoint = array_shift( $this->args );
        if ( array_key_exists( 0, $this->args ) && !is_numeric( $this->args[0] )) {
            $this->verb = array_shift( $this->args );
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ( $_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE' ) {
                $this->method = 'DELETE';
            } else if ( $_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT' ) {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->_cleanInputs($_POST);
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_GET);
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }

    /**
    * Public Function: getDB
    * Creates a new connection to the database.
    * Returns connection.
    */
    public function getDB( $dbname ) {
        $dbhost = $_ENV["DATABASE_SERVER"];
        $dbuser = "db161944_eqipmnt";
        $dbpass = "WhatAreTh0se?";

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

    /**
    * Public Function: processAPI
    * Determines if API contains method for requested endpoint.
    * Calls specified method or 404s.
    */
    public function processAPI() {
        if ( method_exists( $this, $this->endpoint ) ) {
            return $this->_response( $this->{$this->endpoint}( $this->args ) );
        }
        return $this->_response( "No Endpoint: $this->endpoint", 404 );
    }

    /**
    * Private Function: _response
    * Creates response data and response status header.
    */
    private function _response( $data, $status = 200 ) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus( $status ));
        return json_encode( $data );
    }

    /**
    * Private Function: _cleanInputs
    * Trims and strips tags of all request inputs
    * Returns array of cleaned inputs
    */
    private function _cleanInputs( $data ) {
        $clean_input = Array();
        if ( is_array( $data ) ) {
            foreach ( $data as $k => $v ) {
                $clean_input[$k] = $this->_cleanInputs( $v );
            }
        } else {
            $clean_input = trim( strip_tags ( $data ) );
        }
        return $clean_input;
    }

    /**
    * Private Function: _requestStatus
    * Returns text representation of status code.
    */
    private function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }
}