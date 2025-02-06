<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FootballApiService;
use Illuminate\Http\Request;

class FootballController extends Controller
{
    protected $footballApi;

    public function __construct(FootballApiService $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    public function leagues()
    {
        $leagues = $this->footballApi->getLeagues();

        return response()->json([
            'body' => $leagues,
            'success' => true,
            'msg'=> null
        ], 200);
    }

    public function teams()
    {
        $teams = $this->footballApi->getTeams();
        
        return response()->json([
            'body' => $teams,
            'success' => true,
            'msg'=> null
        ], 200);
    }

    public function results(Request $request)
    {
        try {

            $results = $this->footballApi->getResults($request);
            
            return response()->json([
                'body' => $results,
                'success' => true,
                'msg'=> null
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'body' => null,
                'success' => false,
                'msg'=> $th->getMessage()
            ], 403);
        }
    }
}
