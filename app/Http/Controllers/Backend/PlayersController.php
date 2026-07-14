<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\DBHelper;
use App\Http\Controllers\Controller;
use App\Models\BattingStyles;
use App\Models\BowlingStyles;
use App\Models\PlayerLevels;
use App\Models\PlayerRegistrationNumbers;
use App\Models\PlayerRoles;
use App\Models\Players;
use App\Models\PlayerStatuses;
use App\Models\Schools;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayersController extends Controller
{
    public function index(Request $request)
    {
        $userAccess = isAllUserRolesAllowed();

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
            ->orderBy('players.registration_number', 'DESC')
            ->paginate(20)
            ->withQueryString();

        return view('backend.players.index',[
            'records' => $records,
            'keyword' => $keyword,
            'user_access' => $userAccess,
        ]);
    }

    public function view(Request $request, $playerId){
        $userAccess = isAllUserRolesAllowed();

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


        return view('backend.players.view',[
            'user_access' => $userAccess,
            'player' => $player,
        ]);
    }

    public function create(Request $request){
        $userAccess = isAllUserRolesAllowed();

        $playerLevels = PlayerLevels::where('status', 1)->get();
        $playerRoles = PlayerRoles::where('status', 1)->orderBy('player_role', 'ASC')->get();
        $battingStyles = BattingStyles::where('status', 1)->get();
        $bowlingStyles = BowlingStyles::where('status', 1)->orderBy('bowling_style', 'ASC')->get();
        $schools = Schools::where('status', 1)->orderBy('school', 'ASC')->get();
        $playerStatuses = PlayerStatuses::where('status', 1)->get();
        $sizes = $this->sizes;

        return view('backend.players.create',[
            'user_access' => $userAccess,
            'player_levels' => $playerLevels,
            'player_roles' => $playerRoles,
            'batting_styles' => $battingStyles,
            'bowling_styles' => $bowlingStyles,
            'schools' => $schools,
            'sizes' => $sizes,
            'player_statuses' => $playerStatuses,
        ]);
    }

    public function edit(Request $request, $playerId){
        $userAccess = isAllUserRolesAllowed();

        $player = Players::find($playerId);

        $playerLevels = PlayerLevels::where('status', 1)->get();
        $playerRoles = PlayerRoles::where('status', 1)->orderBy('player_role', 'ASC')->get();
        $battingStyles = BattingStyles::where('status', 1)->get();
        $bowlingStyles = BowlingStyles::where('status', 1)->orderBy('bowling_style', 'ASC')->get();
        $schools = Schools::where('status', 1)->orderBy('school', 'ASC')->get();
        $playerStatuses = PlayerStatuses::where('status', 1)->get();
        $sizes = $this->sizes;

        return view('backend.players.create',[
            'user_access' => $userAccess,
            'player' => $player,
            'player_levels' => $playerLevels,
            'player_roles' => $playerRoles,
            'batting_styles' => $battingStyles,
            'bowling_styles' => $bowlingStyles,
            'schools' => $schools,
            'sizes' => $sizes,
            'player_statuses' => $playerStatuses,
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required'],
        ]);

        $isNewPlayer = 0;

        if(!empty($request->id)){
            $save = Players::find($request->id);
        }
        else{
            $save = new Players();
            $isNewPlayer = 1;
        }

        $save->first_name = $request->first_name;
        $save->last_name = $request->last_name;
        $save->date_of_birth = $this->dbInsertTime($request->date_of_birth);

        $save->gender = !empty($request->gender) ? $request->gender : null;
        $save->date_of_join = !empty($request->date_of_join) ? $this->dbInsertTime($request->date_of_join) : null;
        $save->school_id = !empty($request->school_id) ? $request->school_id : null;
        $save->player_level_id = !empty($request->player_level_id) ? $request->player_level_id : null;
        $save->batting_style_id = !empty($request->batting_style_id) ? $request->batting_style_id : null;
        $save->bowling_style_id = !empty($request->bowling_style_id) ? $request->bowling_style_id : null;
        $save->player_role_id = !empty($request->player_role_id) ? $request->player_role_id : null;
        $save->jersey_number = !empty($request->jersey_number) ? $request->jersey_number : null;
        $save->jersey_name = !empty($request->jersey_name) ? $request->jersey_name : null;
        $save->description = !empty($request->description) ? $request->description : null;
        $save->contact_1 = !empty($request->contact_1) ? $request->contact_1 : null;
        $save->contact_2 = !empty($request->contact_2) ? $request->contact_2 : null;
        $save->emergency_contact_1_name = !empty($request->emergency_contact_1_name) ? $request->emergency_contact_1_name : null;
        $save->emergency_contact_1 = !empty($request->emergency_contact_1) ? $request->emergency_contact_1 : null;
        $save->emergency_contact_2_name = !empty($request->emergency_contact_2_name) ? $request->emergency_contact_2_name : null;
        $save->emergency_contact_2 = !empty($request->emergency_contact_2) ? $request->emergency_contact_2 : null;
        $save->image = !empty($request->image) ? $request->image : 'player.jpg';
        $save->tshirt_size = !empty($request->tshirt_size) ? $request->tshirt_size : null;
        $save->bottom_size = !empty($request->bottom_size) ? $request->bottom_size : null;
        $save->player_status_id = !empty($request->player_status_id) ? $request->player_status_id : null;
        $save->save();

        if (!empty($isNewPlayer)) {

            // Generate Player Registration Number
            $r = new PlayerRegistrationNumbers();
            $r->player_id = $save->id;
            $r->save();



            // Generate Player QR Code
            $qr = $this->generateQRCode($save->id, $r->id);


            // Update Player
            $u = Players::find($save->id);
            $u->registration_number = $r->id;
            $u->qr_code = $qr;
            $u->save();
        }


        session()->flash('success', 'Player details has been saved successfully!');
        return redirect(route('backend.players.edit', $save->id));
    }

    public function imageUpload(Request $request){

        $status = 'error';
        $file_name = '';

        if($request->ajax()){

            $img = $this->commonImageUpload($request, 'players');
            $file_name = $img['file_name'];
            $status = $img['status'];

            return response()->json([
                'status' =>  $status,
                'filename' =>  $file_name,
            ]);

        }
    }

}
