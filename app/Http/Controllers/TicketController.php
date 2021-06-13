<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use App\Http\Requests\StoreTicketQuantity;
use App\Http\Requests\UpdateTicketEntry;
use Carbon\Carbon;

class TicketController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $perPage = request()->per_page ??10;
        $sortBy = request()->sort_by ?? 'created_at';
        $sortDesc = request()->sort_desc =='true' ? 'desc':'asc';
    
        $ticket = auth()->user()->tickets()->orderBy($sortBy,$sortDesc)->paginate($perPage);     
        
        return response()->json($ticket);
    }

     /**
     * count Tickets in Use
     *
     * @return \Illuminate\Http\Response
     */
    public function inUse()
    {
        return response()->json(['count'=>auth()->user()->tickets()->where('entry',1)->count()],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketQuantity  $request
     * @param \App\User
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketQuantity $request)
    {   
        $bucket = [];     
        for($ticket = 0 ; $ticket < $request->quantity; $ticket++){
            $attributes['ticket_no']  = $this->randomTicketNo();
            $attributes['user_id']    = auth()->id();
            
            array_push($bucket,$attributes);
        }
        
        $tickets = Ticket::insert($bucket);

        if($tickets)
            return response()->json(['result' =>$tickets,'message'=>'Ticket(s) successfully purchased'],201);
        else
            return response()->json(['message'=>'Purchasing ticket(s) failed.'],500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketEntry  $request
     * @param \App\Ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketEntry $request,Ticket $ticket)
    {
        $attributes['entry'] = $request->entry;
        
        if($request->entry)
            $attributes['expires_at'] = Carbon::now()->addDay();
        
        $result = $ticket->update($attributes);

        if($result)
            return response()->json(['result' =>$result,'message'=>'Ticket successfully updated'],200);
        else
            return response()->json(['message'=>'Ticket update failed.'],500);
    }

     /**
     * random ticket generator
     */
    protected function randomTicketNo() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 9; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
