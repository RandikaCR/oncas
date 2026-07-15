<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Venues;
use Illuminate\Http\Request;

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

    public function view(Request $request){
        $userAccess = isAllUserRolesAllowed();

        $venues = Venues::where('status', 1)->orderBy('venue', 'ASC')->get();

        return view('backend.events.create',[
            'user_access' => $userAccess,
            'venues' => $venues,
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
}
