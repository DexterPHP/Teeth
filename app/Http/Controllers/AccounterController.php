<?php

namespace App\Http\Controllers;

use App\Models\Accounter;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccounterController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $valid =  $request->validate([
                'accounter_fname' => 'required|unique:accounters|max:191'
            ]);
            $uuid = Str::uuid()->toString();
            $request['uuid'] = $uuid;
            $Accounter = Accounter::create($request->all());
            return redirect()->back()->with('Essia','Hello');

        }else{
            // get
            $centers = Center::all();
            $arr['centersx']= $centers;
            return view('accounter.add_accounter',$arr);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounter\Accounter  $accounter
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $Accounter_data = Accounter::all();
        $arr['Account_data'] = $Accounter_data;
        $center = Center::all();
        $arr['centes'] = $center;
        return  view('accounter.show_all',$arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounter\Accounter  $accounter
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounter $accounter)
    {
        $Accounter_data = Accounter::all();
        $arr['Account_data'] = $Accounter_data;
        $center = Center::all();
        $arr['centes'] = $center;
        return  view('accounter.edit_accounter',$arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounter\Accounter  $accounter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('post')){
            $good = Accounter::where('uuid',$id)->first();
            $good->update($request->all());
            return redirect()->back()->with('done',' ');


        }else{
            $accounter_data = Accounter::where('uuid',$id)->first();
            $arr['accounter_data_is'] = $accounter_data;
            $cent = Center::all();
            $arr['centersx'] = $cent;
            return view('accounter.update_accounter',$arr);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounter\Accounter  $accounter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounter $accounter)
    {
        //
    }
}
