<?php

namespace App\Http\Controllers;

use App\ticket;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use App\message;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = new ticket;

        if(!empty($request->postby)){ //created by adalah username yang buat
            $tickets = $tickets->Where(function($query) use ($request){
                foreach (explode(",", $request->postby) as $key => $value) {
                    $query = $query->orWhere('created_by','like','%'.$value.'%');
                }
            });
        }
        if(!empty($request->question)){
            $tickets = $tickets->orWhere(function($query) use ($request){
                foreach (explode(",", $request->question) as $key => $value) {
                    $query = $query->orWhere('description','like','%'.$value.'%');
                }
            });

            $tickets = $tickets->orWhere(function($query) use ($request){
                foreach (explode(",", $request->question) as $key => $value) {
                    $query = $query->orWhere('title','like','%'.$value.'%');
                }
            });
        }


        // dump($tickets->toSql());
        // dd($tickets->getBindings());

        $tickets = $tickets->orderBy('id', 'desc');

        if(!empty($request->paginate)){
            $paginate = $request->paginate;
        }else{
            $paginate = 20;
        }

        $navbar = $this->navbar();

        $tickets = $tickets->paginate($paginate);

        $tickets->appends(Input::except('page'))->links();


        return view('ticket',compact('tickets','navbar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $navbar = $this->navbar();

        // $patients = DB::table('sysdb.users')->where('groupid','=','patient')->get();
        // $doctors = DB::table('users')->where('groupid','=','doctor')->get();
        return view('ticket_create',compact('doctors','patients','navbar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // $report_validate = (Auth::user()->groupid=='doctor') ? 'required':'';

        ////validate ticket
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required|min:5',
            'created_by' => 'required',
            // 'report_by' => $report_validate
        ]);

        if(empty($request->category)){
            $request->category = 'None';
        }

        if(empty($request->priority)){
            $request->priority = 'Low';
        }

        if(empty($request->assign_to)){
            $request->assign_to = 'All';
        }

        ////create new ticket
        $message = new ticket;

        $message->title = $request->title;
        $message->category = $request->category;
        $message->priority = $request->priority;
        $message->description = $request->description;
        $message->assign_to = $request->assign_to;
        $message->created_by = $request->created_by;
        $message->status = "Open";
        // $message->report_by = (Auth::user()->groupid=='patient') ? Auth::id() : $request->report_by;

        $message->save();

        return redirect()->route('ticket');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(ticket $ticket)
    {
        // if(Auth::user()->groupid=='patient' && Auth::user()->id != $ticket->report_by){
        //     return redirect()->back();
        // }

        $navbar = $this->navbar();

        return view('ticket_detail',compact('ticket','navbar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ticket $ticket)
    {
        if(!empty($request->text)){
            $ticket->description = $request->text;
            $ticket->updflg = '1';
        }
        if(!empty($request->status)){
            $ticket->assign_to = $request->assign_to;
            $ticket->status = $request->status;
            $ticket->priority = $request->priority;
            $ticket->category = $request->category;
        }

        $ticket->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ticket $ticket)
    {
        //
    }

    public function answer(User $user)
    {

        // $patients = DB::table('users')->where('groupid','=','patient')->get();
        // $doctors = DB::table('users')->where('groupid','=','doctor')->get();

        $navbar = $this->navbar();
        $answer = message::where("user_id","=",$user->id)->distinct('ticket_id')->pluck("ticket_id");
        $tickets = ticket::whereIn('id', $answer)->paginate();

        return view('ticket',compact('tickets','patients','doctors','navbar'));
    }
}
