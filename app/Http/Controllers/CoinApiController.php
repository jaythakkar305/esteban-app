<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinApiController extends Controller
{
    /**
     * Display a listing of the coinapi.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client(['headers' => ['X-CoinAPI-Key' => config('app.coinapi_key')]]);
            $request = $client->get(config('app.coinapi_endpoint'));
            $response = $request->getBody()->getContents();
            $response_array = json_decode($response, true);
            if ($request->getStatusCode() != '200') {
                throw new \Exception(isset($response_array['message']) ? $response_array['message'] : 'Something went wrong while fetching data from api.');
            }
            
            $coin_data = json_decode($response);                                    
            return response()->json(['coindata' => $coin_data, 'message' => 'Succesfully fetched'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 201);
        }
        //$projects = Projects::paginate($request->all());        
    }
}
