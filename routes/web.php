<?php


Route::get('/', function() {
    return view('start');
});
Route::post('/', function(\Illuminate\Http\Request $request) {
    $url = $request->get('url');
    $match = new \App\Match($url);

    $seasonMatch = \App\SeasonMatch::where('matchId', '=', $match->id)->first();

    if (is_null($seasonMatch)) {
        $seasonMatch = \App\SeasonMatch::insert([
            'matchId' => $match->id,
            'team1id' => $match->team1id,
            'team1' => $match->team1,
            'team2id' => $match->team2id,
            'team2' => $match->team2,
            'time' => $match->time,
            'mode' => $match->mode,
        ]);
    }

    return view('matchlink', compact('match', 'seasonMatch'));
});

Route::get('/match/{match}/{teamId}', function ($match, $teamId) {
    $seasonMatch = \App\SeasonMatch::where('matchId', '=', $match)->first();

    if (is_null($seasonMatch)) {
        return 'Match not found';
    }

    $teams = $seasonMatch->team1 . ' vs ' . $seasonMatch->team2;
    $date = $seasonMatch->time;

    if ($seasonMatch->mode == 'Mapwahl BO3') {
        $maps = 3; // BO3
    } else {
        $maps = 1;
    }

    $myTeam = $teamId;
    $team1 = $seasonMatch->team1id;
    $team2 = $seasonMatch->team2id;
    $activeMaps = (new \App\MapPool($match))->getMaps();

    if ($seasonMatch->result != '') {
        $result = unserialize($seasonMatch->result);
        $locked = 'true';
        $voter = 'nobody';
    } else {
        $result = '';
        $locked = 'false';
        $voter = $team1;
    }

    return view('vote', compact('match', 'teamId', 'myTeam', 'team1', 'team2', 'teams', 'date', 'maps', 'voter', 'activeMaps', 'result', 'locked'));
});

Route::get('/dismiss/{matchId}/{teamId}/{map}', function($matchId, $teamId, $map) {
    $existingMapVotes = \App\Maps::where('matchId', '=', $matchId)->count();

//    \App\Maps::create([
//        'matchId' => $matchId,
//        'teamId' => $teamId,
//        'count' => $existingMapVotes + 1,
//        'map' => $map,
//    ]);

    $engine = new ElephantIO\Engine\SocketIO\Version1X('http://mapvote.dev:3000');
    $elephant = new \ElephantIO\Client($engine);
    $elephant->initialize(false);
    $elephant->emit('dismissed', [
        'match' => $matchId,
        'map' => $map
    ]);

    return 'OK';
});

Route::post('/maps/{matchId}', function(\Illuminate\Http\Request $request, $matchId) {
    $maps = $request->get('maps');

    $collection = collect($maps);
    $randomMaps = $collection->shuffle()->toArray();

    $seasonMatch = \App\SeasonMatch::where('matchId', '=', $matchId)->first();
    $seasonMatch->result = serialize($randomMaps);
    $seasonMatch->save();

    return $randomMaps;
});
