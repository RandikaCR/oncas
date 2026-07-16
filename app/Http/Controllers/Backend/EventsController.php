<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\DBHelper;
use App\Helpers\PlayersHelper;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\PlayerAttendances;
use App\Models\Players;
use App\Models\Venues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isAllUserRolesAllowed();

        $keyword = !empty($request->keyword) ? $request->keyword : null;

        $records = Events::select(
            'events.*',
            'venues.venue',
        )
            ->join('venues', 'events.venue_id', 'venues.id')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where('events.event', 'like', '%' . $keyword . '%')
                    ->orWhere('events.description', 'like', '%' . $keyword . '%')
                    ->orWhere('venues.venue', 'like', '%' . $keyword . '%');
            })
            ->orderBy('events.created_at', 'DESC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.events.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function view(Request $request, $eventId){
        $userAccess = isAllUserRolesAllowed();

        $event = Events::select('events.*', 'venues.venue')
            ->join('venues', 'events.venue_id', 'venues.id')
            ->where('events.id', $eventId)
            ->first();

        return view('backend.events.view',[
            'user_access' => $userAccess,
            'event' => $event,
        ]);
    }

    public function create(Request $request){
        $userAccess = isAllUserRolesAllowed();

        $venues = Venues::where('status', 1)->orderBy('venue', 'ASC')->get();

        return view('backend.events.create',[
            'user_access' => $userAccess,
            'venues' => $venues,
        ]);
    }

    public function edit(Request $request, $eventId){
        $userAccess = isAllUserRolesAllowed();

        $event = Events::find($eventId);

        $venues = Venues::where('status', 1)->orderBy('venue', 'ASC')->get();

        return view('backend.events.create',[
            'user_access' => $userAccess,
            'event' => $event,
            'venues' => $venues,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'venue_id' => ['required'],
            'event' => ['required', 'string', 'max:500'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);

        if(!empty($request->id)){
            $save = Events::find($request->id);
        }
        else{
            $save = new Events();
            $save->is_completed = 0;
            $save->is_canceled = 0;
            $save->status = 1;
            $save->created_by = $this->userId;
        }

        $save->venue_id = $request->venue_id;
        $save->event = $request->event;
        $save->start_time = $this->dbInsertTime($request->start_time);
        $save->end_time = $this->dbInsertTime($request->end_time);
        $save->description = !empty($request->description) ? $request->description : null;
        $save->save();


        session()->flash('success', 'Event details has been saved successfully!');
        return redirect(route('backend.events.index'));
    }

    public function status(Request $request){
        $req = $request->all();
        $id = !empty($req['id']) ? $req['id'] : 0;

        $text = '';
        $class = '';

        if (!empty($id)){
            $get = Events::find($id);

            if ($get->status == 1){
                $get->status = 0;
            }else {
                $get->status = 1;
            }
            $get->save();
            $status = 'success';
            $get = Events::find($id);
            $getStatus = commonStatus($get->status);
            $text = $getStatus['text'];
            $class = $getStatus['class'];

        }else{
            $status = 'error';
        }


        $out = [
            'status' => $status,
            'text' => $text,
            'class' => $class,
        ];
        return response()->json($out);

    }

    public function getAttendancesViaAjax(Request $request){

        $keyword = !empty($request->keyword) ? $request->keyword : '';
        $perPage = !empty($req['per_page']) ? $req['per_page'] : 20;

        $attendances = PlayerAttendances::select('player_attendances.*', 'players.first_name', 'players.last_name', 'players.registration_number')
            ->join('players', 'players.id', 'player_attendances.player_id')
            ->where(function ($query) use ($keyword) {
                if (!empty($keyword)){
                    return $query->where(DB::raw(DBHelper::dbConcat('players', 'first_name','players', 'last_name')), 'like', '%' . $keyword . '%')
                        ->orWhere('players.registration_number', 'like', '%' . $keyword . '%');
                }
            })
            ->where('player_attendances.event_id', $request->event_id)
            ->orderBy('player_attendances.created_at', 'DESC')
            ->paginate($perPage)
            ->withQueryString();

        $body = view('backend.ajax.event-attendances', ['attendances' => $attendances])->render();
        $pagination = view('backend.ajax.default-pagination', ['pagination' => $attendances])->render();

        $totalRecords = !empty($attendances->total()) ? $attendances->total() : 0;
        $showingFirstItem = !empty($attendances->firstItem()) ? $attendances->firstItem() : 0;
        $showingLastItem = !empty($attendances->lastItem()) ? $attendances->lastItem() : 0;

        $out = [
            'body' => $body,
            'pagination' => $pagination,
            'total_count' => $totalRecords,
            'showing_first_item' => $showingFirstItem,
            'showing_last_item' => $showingLastItem,
        ];

        return response()->json($out);
    }

    public function getPlayers(Request $request){
        $keyword = !empty($request->keyword) ? $request->keyword : null;

        $records = Players::select(
            'players.*',
            'schools.school',
            'player_levels.player_level',
            'batting_styles.batting_style',
            'bowling_styles.bowling_style',
            'player_roles.player_role',
            'player_statuses.player_status',
            'player_statuses.label AS status_label',
        )
            ->leftJoin('player_levels', 'players.player_level_id', 'player_levels.id')
            ->leftJoin('schools', 'players.school_id', 'schools.id')
            ->leftJoin('batting_styles', 'players.batting_style_id', 'batting_styles.id')
            ->leftJoin('bowling_styles', 'players.bowling_style_id', 'bowling_styles.id')
            ->leftJoin('player_roles', 'players.player_role_id', 'player_roles.id')
            ->leftJoin('player_statuses', 'players.player_status_id', 'player_statuses.id')
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where(DB::raw(DBHelper::dbConcat('players', 'first_name', 'players', 'last_name')), 'like', '%' . $keyword . '%')
                    ->orWhere('players.registration_number', 'like', '%' . $keyword . '%')
                    ->orWhere('players.jersey_number', 'like', '%' . $keyword . '%')
                    ->orWhere('players.jersey_name', 'like', '%' . $keyword . '%')
                    ->orWhere('players.contact_1', 'like', '%' . $keyword . '%')
                    ->orWhere('players.contact_2', 'like', '%' . $keyword . '%')
                    ->orWhere('players.emergency_contact_1', 'like', '%' . $keyword . '%')
                    ->orWhere('players.emergency_contact_1_name', 'like', '%' . $keyword . '%')
                    ->orWhere('players.emergency_contact_2', 'like', '%' . $keyword . '%')
                    ->orWhere('players.emergency_contact_2_name', 'like', '%' . $keyword . '%')
                    ->orWhere('schools.school', 'like', '%' . $keyword . '%');
            })
            ->orderBy('players.registration_number', 'ASC')
            ->get();


        $players = [];
        foreach ($records as $record) {
            $record->reg_no = generatePlayerID($record->registration_number);
            $players[] = $record;
        }

        return response()->json($players);
    }


    public function setAttendance(Request $request){

        $req = $request->all();
        $a = new PlayersHelper();
        $out = $a->setPlayerAttendance($req);

        return response()->json($out);
    }

    public function setAsCompleted(Request $request){

        $eventId = $request->event_id;
        $e = Events::find($eventId);
        $e->is_completed = 1;
        $e->completed_by = $this->userId;
        $e->completed_at = $this->dbInsertTime();
        $e->save();

        $out = ['status' => 'success'];
        return response()->json($out);
    }


}
