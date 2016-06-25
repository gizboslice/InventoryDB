<?php

require_once 'TestAPI.php';

// Add HTTP_ORIGIN header if request coming from same server
if ( !array_key_exists( 'HTTP_ORIGIN', $_SERVER ) ) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}


try {
    $API = new TestAPI( $_REQUEST['request'], $_SERVER['HTTP_ORIGIN'], $_SERVER['QUERY_STRING'] );
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode( Array( 'error' => $e->getMessage() ) );
}