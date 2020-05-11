<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
Use App\student;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidRut;
use Illuminate\Support\Str;

class StudentsController extends BaseController
{

   /**
     * Validate and Create a new student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'rut' => ['required','regex:/^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/', new ValidRut],
            'name' => 'required|max:100|regex:/^([^0-9]*)$/',
            'lastName' => 'required|max:100|regex:/^([^0-9]*)$/',
            'age' => 'required|integer|min:18',
            'course' => 'required|integer|exists:courses,id'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //Transform RUT into only number & K string before saving. Removes dots and dash
        if(isset($input['rut'])) $input['rut'] = Str::of($input['rut'])->replace('.','')->replace('-','')->replace('k','K');;

        //Additional validation to avoid repeated rut/courses
        if( count( student::where('rut',$input['rut'])->where('course',$input['course'])->get() ) > 0 ) return $this->sendError('Student already enrolled in course.');      

        $student = student::create($input);    
        return $this->sendResponse($student->toArray(), 'Student created successfully.', 201);
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = student::with('course')->find($id); //Find course related

        if(is_null($student)){// If no student is retrieved
            return $this->sendError('Student Does Not Exist.');       
        }
        return $this->sendResponse($student->toArray(), 'Student retrieved successfully.');        
    }

    /**
     * Display paged students.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPages($page=1)
    {
        $students = student::with('course')->paginate(5);

        return $this->sendResponse($students->toArray(), 'Students retrieved successfully (paged).');        
    }

    /**
     * Display all students.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $students = student::with('course')->get();

        return $this->sendResponse($students->toArray(), 'Students retrieved successfully.');
    }


   /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        if(
        !isset($input['rut']) and 
        !isset($input['name']) and 
        !isset($input['lastName']) and
        !isset($input['age']) and
        !isset($input['course'])
        ){// If no field is given
            return $this->sendError('No data given in request.');       
        }

        $student = student::find($id);

        if(is_null($student)){// If no course is retrieved
            return $this->sendError('Student Does Not Exist.');       
        }

        $validator = Validator::make($input, [
            'rut' => ['regex:/^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/', new ValidRut],
            'name' => 'max:100|regex:/^([^0-9]*)$/',
            'lastName' => 'max:100|regex:/^([^0-9]*)$/',
            'age' => 'integer|min:18',
            'course' => 'integer|exists:courses,id'
        ]);
  
        if($validator->fails()){//Errors in the request fields 
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //Updating fields that exists in request
        if(isset($input['rut'])) $student->code = $input['rut'];
        if(isset($input['name'])) $student->name = $input['name'];
        if(isset($input['lastName'])) $student->lastName = $input['lastName'];
        if(isset($input['age'])) $student->age = $input['age'];
        if(isset($input['course'])){ 
            $student->course = $input['course'];
        }

        //Additional validation to avoid repeated rut/courses
        if( count( student::where('rut',$student->rut)->where('course',$student->course)->where('id','<>',$id)->get() ) > 0 ) return $this->sendError('Student already enrolled in destination course.');

        $student->update();
        $student = student::with('course')->find($id); //Refresh Student with course info
        return $this->sendResponse($student->toArray(), 'Student updated successfully.');        
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = student::with('course')->find($id);
        if(is_null($student)){// If no student is retrieved
            return $this->sendError('Student Does Not Exist.');       
        }

        $student->delete();
        return $this->sendResponse($student->toArray(), 'Student deleted successfully.');
    }
}
