<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CurlController extends Controller
{

    //https://apps.vietjack.com:8081/api/books --api server khách
    public function getSubjects()
    {

        // $response = Http::get('https://apps.vietjack.com:8081/api/books');

        // if ($response == true) {
        //     $response->successful();
        //     return response()->json(['data' => 'co du lieu']);
        // }


        $url = 'https://apps.vietjack.com:8081/api/books';
        $curl = curl_init($url);

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcHMudmlldGphY2suY29tOjgwODEvYXBpL2F1dGgvc29jaWFsLWxvZ2luIiwiaWF0IjoxNjcxMDI1NDgxLCJleHAiOjE2NzE2MzAyODEsIm5iZiI6MTY3MTAyNTQ4MSwianRpIjoieWthUzN2WDZ2czJPandLUCIsInN1YiI6MzM5ODczNCwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.PkRHVlu0LeOXEp5GxYOdNl3zrg65jD9-LBqSbBiOW1s';

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}
