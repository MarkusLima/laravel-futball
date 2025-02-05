<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FootballApiService;

class FootballController extends Controller
{
    protected $footballApi;

    public function __construct(FootballApiService $footballApi)
    {
        $this->footballApi = $footballApi;
    }
    public function index(Request $request)
    {
        $results = [];
        $times = [];
        $leagues = [];

        try {
            
            $leagues = $this->footballApi->getLeagues();
    
            if (!empty($request->league_id) && !empty($request->season)) {
                $results = $this->footballApi->getResults($request->league_id, $request->season);
    
                if (!empty($results['response']) && count($results['response']) > 0) {
                    $uniqueTimes = [];
    
                    foreach ($results['response'] as $key => $value) {
                        $homeTeamId = $value['teams']['home']['id'];
                        $awayTeamId = $value['teams']['away']['id'];
    
                        $uniqueTimes[$homeTeamId] = [
                            'id' => $homeTeamId,
                            'name' => $value['teams']['home']['name']
                        ];
    
                        $uniqueTimes[$awayTeamId] = [
                            'id' => $awayTeamId,
                            'name' => $value['teams']['away']['name']
                        ];
                    }
    
                    $times = array_values($uniqueTimes);
    
                    // Se o parâmetro team_id estiver presente, filtra apenas os jogos desse time
                    if (!empty($request->team_id)) {
                        $results['response'] = array_filter($results['response'], function ($game) use ($request) {
                            return $game['teams']['home']['id'] == $request->team_id || $game['teams']['away']['id'] == $request->team_id;
                        });
                    }
                }
            }
    
            return view('home', compact('leagues', 'results', 'times'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return view('home', compact('leagues', 'results', 'times'));
        }
    }
    
}

