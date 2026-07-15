<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PlayersHelper;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Players;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function qrView(Request $request, $playerId){

        $p = new PlayersHelper();
        $player = $p->getPlayer($playerId);

        return view('frontend.players.qr-index', [
            'player' => $player,
        ]);
    }

    public function attendances(Request $request, $playerId){

        $p = new PlayersHelper();
        $player = $p->getPlayer($playerId);

        $events = Events::select('events.*', 'venues.venue')
            ->join('venues', 'events.venue_id', 'venues.id')
            ->where('events.status', 1)
            ->where('events.is_completed', 0)
            ->where('events.is_canceled', 0)
            ->where('venues.status', 1)
            ->orderBy('events.start_time', 'DESC')
            ->get();

        return view('frontend.players.attendances', [
            'player' => $player,
            'events' => $events,
        ]);
    }

    public function setAttendance(Request $request){
        $status = 'success';
        $message = 'Player has been marked as attended.';



        $out = [
            'status' => $status,
            'message' => $message,
        ];
        return response()->json($out);
    }


}
