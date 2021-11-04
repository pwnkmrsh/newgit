<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\MyClass;
use App\User;
use App\Mark;
use \Crypt;
use DB;
use DataTables;


use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Support\Facades\Hash; 

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($user) {
                       return [
                          'display' => e($user->created_at->format('m/d/Y')),
                          'timestamp' => $user->created_at->timestamp
                       ];
                    })
                    ->filterColumn('created_at', function ($query, $keyword) {
                       $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') LIKE ?", ["%$keyword%"]);
                    })
                    ->make(true);
        }
        
        //get student list here
        $classes =  \App\MyClass::orderBy('className', 'asc')->get();
        $students =  \App\Student::join('my_classes as C', 'students.class_id', '=', 'C.id')
                    ->orderBy('name', 'asc')->simplePaginate(5);
        return view('student',compact('students', 'classes'));
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$data['my_classes'] = \App\MyClass::orderBy('className', 'asc')->get();
        $data['my_classes'] = \App\MyClass::pluck('className', 'id');
        return view('student_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
       /*  $request->validate([
            'roll_no' => 'required',
            'name' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]); */
        $fullName = $request->name." ".$request->lastName;  

        $users = User::create([
            'name' => $request['name'],
            'email' => $request['name'].'@test.om',
            'password' => Hash::make(123456),
        ]);
        if($users){
            $request = new Student;
            $request->user_id = $users->id; //get last inserted id 
            $request->name = $fullName;  
            $imageName = time().'.'.request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('photo'), $imageName);
            $request->photo = $imageName;  
            $request->class_id = request()->class_id;
            $request->roll_no = 1000+$users->id;  
            $request->save();
            return redirect('/student-create')->with('status', 'Student is successfully saved');

        }
       
       
       // return back()->with('success','You have successfully added.')->with('photo',$imageName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markEntry($roll_no, $classID)
    {
        //$rollNo = Crypt::decrypt($roll_no);
        $roll_no =$roll_no;
        $subjects = \App\Subject::where('my_class_id', '=', $classID)->get();
        if(count($subjects)>0){
            return view('mark_entry',compact('subjects', 'roll_no'));
        }else{
            return 'There is no subject. Please add subject for this Class'.$classID;
        }
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

    public function markStore(Request $request)
    { 
        
        $student_sub = $request->row;
        $insert_ary = [];
        foreach ($student_sub as $key => $value) {
            $insert_ary[$key] = $value;
            $insert_ary[$key]['roll_no'] = $request->roll_no;
            $insert_ary[$key]['student_id'] = $request->roll_no;
            $insert_ary[$key]['my_class_id'] = $request->class_id;
            $insert_ary[$key]['sessID'] = '2021';
            $insert_ary[$key]['total'] = $request->total;
            $insert_ary[$key]['totalMark'] = 500;

        }
        DB::table('marks')->insert($insert_ary);
        return redirect('/student')->with('status', 'Marks is successfully saved');

       
       
    }
}
