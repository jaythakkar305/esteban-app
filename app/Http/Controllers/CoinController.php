<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class CoinController extends Controller
{
    /**
     * Display a listing of the coinapi.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request1)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->get(url('/api/coinapi'));
            $response = $request->getBody()->getContents();
            $response_array = json_decode($response, true);
            if ($request->getStatusCode() != '200') {
                throw new \Exception($response_array['message']);
            }            
            $coin_data = $response_array['coindata'];
            return view('coin', compact('coin_data'));
        } catch (\Exception $e) {
            return view('error', ['error' => 'Uh oh! ' . $e->getMessage()]);
        }
    }
}
