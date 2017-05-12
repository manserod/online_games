<?php

namespace Zankyou;

define( 'GAME_URL', 'http://game-WubbaLubba/participate' );

/**
 * This class manage web service interface
 * 
 * Class Api
 * @package Zankyou
 */
class Api
{

    /**
     * @var array
     */
    private $request;

    /**
     * Api constructor.
     */
    public function __construct()
    {
        // get the HTTP method, path and body of the request
        $method = $_SERVER['REQUEST_METHOD'];
        $option = explode( '/', trim( $_SERVER['PATH_INFO'], '/' ) );
        $contest = json_decode( file_get_contents( 'php://input' ), true );

        $this->request = [
            'method' => $method,
            'option' => $option,
            'contest' => $contest
        ];
        
    }

    /**
     * @return array
     */
    public function getContest()
    {
        return [
            'method' => $this->request['method'],
            'option' => $this->request['option'],
            'contest' => $this->request['contest']
        ];

    }

    /**
     * @param $id
     * @param array $gameResponse
     */
    public function sendResponseRequest($id, $gameResponse = array())
    {

        $handler = curl_init();

        // COMMON HEADERS
        $header = ['Content-Type: application/json'];

        // CURL OPTIONS

        curl_setopt( $handler, CURLOPT_URL, GAME_URL );
        curl_setopt( $handler, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt( $handler, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $handler, CURLOPT_POSTFIELDS, json_encode( ["contestId" => $id, "USerId" => "903159", "solution"  => implode(', ', $gameResponse) ]) );

        // EXECUTE CURL
        curl_exec( $handler );
    }


}

