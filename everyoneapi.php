<?php

/**
 * everyoneAPI PHP Library
 *
 * USAGE:
 *
 * #create everyoneAPI object.
 * $obj = new everyoneAPI("[account_sid]", "[auth_token]");
 *
 * #get all data points.
 * $data = $obj->getData("5551234567");
 *
 * #get one data point.
 * $data = $obj->getData("5551234567", "cnam");
 *
 * #get multiple data points.
 * $data = $obj->getData("5551234567", "cnam,line_provider,linetype");
 *
 *
 * NOTES:
 *
 * The datapoints parameter in the getData method is optional. If you omit you will receive all the
 * data points. If you do include it make sure the data point identifiers are comma separated,
 * with no spaces and no trailing comma. You will receive a 400 (Bad Request) response from the
 * API if this parameter is not formatted correctly.
 *
 * You can view a list of data point identifiers in the everyoneAPI docs.
 * https://www.everyoneapi.com/docs
 *
 *
 * @author Antonio Pita <antonio.pita@ctitelecom.com>
 * @copyright 2016 CTiTelecom Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License v2.0
 */

class everyoneAPI
{
    private $account_sid;
    private $auth_token;
    private $request;

    public function __construct($account_sid, $auth_token)
    {
        $this->account_sid = $account_sid;
        $this->auth_token = $auth_token;
    }


    public function getData($phone, $datapoints = NULL)
    {
        $request = "https://api.everyoneapi.com/v1/phone/" . urlencode($phone) . "?";
        if($datapoints != NULL){
            $request .= "data=" . $datapoints . "&";
        }
        $request .= "account_sid=" . urlencode($this->account_sid) . "&auth_token=" . urlencode($this->auth_token);
        // Init CURL session.
        $session = curl_init($request);

        // Set CURL options.
        curl_setopt($session, CURLOPT_HEADER, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // Send the request.
        $response = curl_exec($session);

        // Close CURL session.
        curl_close($session);

        // Get HTTP status code from the response.
        $httpstatus = array();
        preg_match('/\d\d\d/', $response, $httpstatus);

        // Check the HTTP status code for errors and return error if exists.
        switch ($httpstatus[0]) {
            case 200:
                // Request was successful. Move on.
                break;
            case 400:
                $error = "400 Bad Request";
                return $error;
                break;
            case 401:
                $error = "401 Unauthorized";
                return $error;
                break;
            case 402:
                $error = "402 Payment Required";
                return $error;
                break;
            case 403:
                $error = "403 Forbidden";
                return $error;
                break;
            case 404:
                $error = "404 Not Found";
                return $error;
                break;
            case 503:
                $error = "503 Service Unavailable";
                return $error;
            default:
                $error = "Unknown Error: HTTP Status Code (" . $httpstatus[0] . ")";
                return $error;
        }

        // Split JSON from headers.
        $json = substr($response, strpos($response, "{"));

        // Return result as an array.
        $array = json_decode($json);
        return $array;
    }
}
?>