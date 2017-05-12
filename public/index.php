<?php
namespace App;

use Zankyou\Api;
use Zankyou\Core;

require __DIR__ . '/../vendor/autoload.php';

function homeController()
{
    // CHECK URI
    $request = explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) );
    if ($request[0] != 'participate') {
        var_dump( json_encode(['error' => 'method not found. You must use "participate" param.']) );
        return false;
    }

    // GET DICTIONARY
    $file = file_get_contents('../diccionary/dictionary.txt', true);
    $dictionary = explode(",", $file);

    // GET CONTEST
    $api = new Api();
    $request = $api->getContest();

    // GET SOLUTION
    $core = new Core();
    $results = $core->getSolution( $dictionary, $request['contest']['startWord'], $request['contest']['endWord'] );

    //MANAGE RESPONSE
    if ( $results ) {
        // SEND TO​Wubba Lubba Dub Dub! 
        $api->sendResponseRequest( $request['contest']['contestId'], $results );
        
        // NOTIFY TO USER
        var_dump( $core->successResponse( $results ) );
        return true;
    }

    // NOTIFY NOT SOLUTION FOUND TO USER
    var_dump( $core->failResponse() );
    return false;

}

homeController();