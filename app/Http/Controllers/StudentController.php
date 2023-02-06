<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::get();
        if ($request->ajax()) {
            $allData = DataTables::of($students)
            ->addIndexColumn()
            ->addColumn('action',function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
            $row->id.'" data-original-title="Edit" class="edit btn btn-primary btn -sm
            editStudent">Edit</a>';

            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
            $row->id.'" data-original-title="Delete" class="delete btn btn-danger btn -sm
            deleteStudent">Delete</a>';
            return$btn;
         })
         ->rawColumns(['action'])
         ->make(true);
         return $allData;
    }

return view ('students',compact('students'));
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
        Student::UpdateOrCreate(
            ['id'=>$request->student_id],//request the hidden student id
            [
                'name'=>$request->name,
                'email'=>$request->email
            ]
            );
            return response()->json(['success'=>'student added successfully']);
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
        $students = Student::find($id);
        return response()->json($students);
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
        Student::find($id)->delete('');
        return response()->json(['success'=>'student deleted successfully']);
    }
}
