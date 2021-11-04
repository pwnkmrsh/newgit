<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Student;
use Validator;
use DB;

class StudentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = \App\Student::get();
        $students = DB::table('marks as M')
            ->select('S.name as Student Name','M.roll_no','M.totalMark', 'M.s1 as ObtainedMarks', 'S.photo','my_classes.className', 'Sub.subjectName', 'M.total as Total Score')
            ->join('students as S', 'M.roll_no', '=', 'S.roll_no')
            ->join('my_classes', 'M.my_class_id', '=', 'my_classes.id')
            ->join('subjects as Sub', 'M.s2', '=', 'Sub.id')
            ->orderBy('M.s2','DESC');
            if($request->class){
                $students->where('className', 'LIKE', '%'.$request->class.'%');
            }
            if($request->name){
                $students->where('name', 'LIKE', '%'.$request->name.'%');
            }
            if($request->roll){
                $students->where('M.roll_no', '=', $request->roll);
            }
            if($request->totalscore){
                $students->where('M.total', '=', $request->totalscore);
            }
            $students = $students->get();
            
            return $this->sendResponse($students->toArray(), 'Students retrieved successfully.');
    }
 
    public function show($id)
    {
        $Student = Student::find($id);
        if (is_null($Student)) {
            return $this->sendError('Student not found.');
        }
        return $this->sendResponse($Student->toArray(), 'Student retrieved successfully.');
    }

    public function classSearch($id)
    {
        $Student = Student::find($id);
        if (is_null($Student)) {
            return $this->sendError('Student not found.');
        }
        return $this->sendResponse($Student->toArray(), 'Student retrieved successfully.');
    }

  
}