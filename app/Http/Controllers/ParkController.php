<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Park;
use App\Http\Requests\UpdateUserQ;
use Carbon\Carbon;

class ParkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     * 
     * @param String $type
     * @return \Illuminate\Http\Response
     */
    public function index($type='')
    {   
        $perPage = request()->per_page ??10;
        $sortBy = request()->sort_by ?? 'created_at';
        $sortDesc = request()->sort_desc =='true' ? 'desc':'asc';

        $park = Park::all();     

        if(!empty($type))
            $park  = Park::where('type',$type);
    
        $parks = $park->orderBy($sortBy,$sortDesc)->paginate($perPage);
    
        return response()->json($parks);
    }

    /**
     * Display a listing of the rides, shows, attractions that the user is in queue.
     * 
     * @return \Illuminate\Http\Response
     */
    public function qs(){
        return response()->json(auth()->user()->parks()->get());
    }

    /**
     * Display a the number of people in queue
     * 
     * @param \App\Park $park
     * @return \Illuminate\Http\Response
     */
    public function inQ(Park $park){
        return response()->json(['no_of_people_in_queue'=>$park->users()->count()]);
    }

    /**
     * Display a listing of the rides, shows, attractions that the user is in queue.
     * 
     * @return \Illuminate\Http\Response
     */
    public function q(UpdateUserQ $request,Park $park) {
        
        $park->users()->detach(auth()->id());
        
        if($request->value){
            $park->users()->attach(auth()->id());
        }
        
        $message = $request->value ? 'Queued' : 'Removed from the queue.';
        
        return response()->json(['message'=>$message],200);
    }
}
