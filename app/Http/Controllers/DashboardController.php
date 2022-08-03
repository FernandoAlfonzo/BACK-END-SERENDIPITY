<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use App\Models\Generations;
use App\Models\Person;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
{
        $this->middleware('auth');
    }

    public function index()
    {
        $generations = Generations::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->count();

        $collaborators = DB::table('collaborators')
        ->join('persons', 'persons.id', '=', 'collaborators.id_person')
        ->where('collaborators.is_active', '=', 1)
        ->count();
        
        $students_prospect = DB::table('students')
        ->join('persons', 'persons.id', 'students.id_person')
        ->where('students.is_active', 1)
        ->where('students.status', 'PROSPECTO')
        ->count();

        $students = DB::table('students')
        ->join('persons', 'persons.id', 'students.id_person')
        ->where('students.is_active', 1)
        ->where('students.status', 'ALUMNO')
        ->count();



        

        return view('dashboard', ['collaborators' => $collaborators, 'students'=> $students, 'students_prospect'=> $students_prospect, 'generations' => $generations]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
