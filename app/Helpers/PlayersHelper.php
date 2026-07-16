<?php

namespace App\Helpers;

use App\Models\Events;
use App\Models\PlayerAttendances;
use App\Models\Players;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PlayersHelper extends Helper
{
    public function getPlayer($playerId){

        $player = Players::select(
            'players.*',
            'schools.school',
            'player_levels.player_level',
            'batting_styles.batting_style',
            'bowling_styles.bowling_style',
            'player_roles.player_role',
            'player_statuses.player_status',
            'player_statuses.label AS status_label',
            'player_statuses.label AS status_label',
            'player_statuses.label AS status_label',
            'player_statuses.label AS status_label',
            'venues.venue AS last_activity_venue'
        )
            ->leftJoin('player_levels', 'players.player_level_id', 'player_levels.id')
            ->leftJoin('schools', 'players.school_id', 'schools.id')
            ->leftJoin('batting_styles', 'players.batting_style_id', 'batting_styles.id')
            ->leftJoin('bowling_styles', 'players.bowling_style_id', 'bowling_styles.id')
            ->leftJoin('player_roles', 'players.player_role_id', 'player_roles.id')
            ->leftJoin('player_statuses', 'players.player_status_id', 'player_statuses.id')
            ->leftJoin('venues', 'players.last_activity_venue_id', 'venues.id')
            ->where('players.id', $playerId)
            ->first();

        return $player;

    }

    public function setPlayerAttendance($req = []){
        $isInvalid = 0;
        $status = 'success';
        $message = 'Player has been marked as attended.';

        $playerId = !empty($req['player_id']) ? $req['player_id'] : null;
        $eventId = !empty($req['event_id']) ? $req['event_id'] : null;

        // Check whether record already exists
        $a = PlayerAttendances::where('player_id', $playerId)->where('event_id', $eventId)->count();
        if (!empty($a)) {
            $isInvalid++;
            $status = 'error';
            $message = 'Attendance already has been marked.';
        }

        if (empty($isInvalid)){

            $e = Events::find($eventId);

            $save = new PlayerAttendances();
            $save->player_id = $playerId;
            $save->event_id = $eventId;
            $save->start_time = $this->dbInsertTime($e->start_time);
            $save->end_time = $this->dbInsertTime($e->end_time);
            $save->status = 1;
            $save->created_by = Auth::user()->id;
            $save->save();

            // set last activity
            $p = Players::find($playerId);
            $p->last_activity_at = $this->dbInsertTime();
            $save->last_activity_venue_id = $e->venue_id;
            $p->save();
        }

        $out = [
            'status' => $status,
            'message' => $message,
        ];
        return $out;
    }
}

