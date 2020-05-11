<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
Use App\course;
use Illuminate\Support\Facades\Validator;

class CoursesController extends BaseController
{
    /**
     * Validate and Create a new course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:100',
            'code' => 'required|unique:courses|max:4'
        ]);
  
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $course = course::create($input);
        return $this->sendResponse($course->toArray(), 'Course created successfully.', 201);
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $course = course::find($id);

        if(is_null($course)){// If no course is retrieved
            return $this->sendError('Course Does Not Exist.');       
        }
        return $this->sendResponse($course->toArray(), 'Course retrieved successfully.');        
    }

    /**
     * Display paged courses.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPages($page=1)
    {
        $courses = course::paginate(5);

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully (paged).');        
    }


    /**
     * Display all courses.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $courses = course::all();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully.');
    }


    /**
     * Update the specified course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        if(!isset($input['name']) and !isset($input['code'])){// If no field is given
            return $this->sendError('No data given in request.');       
        }        

        $course = course::find($id);

        if(is_null($course)){// If no course is retrieved
            return $this->sendError('Course Does Not Exist.');       
        }

        $validator = Validator::make($input, [
            'name' => 'max:100',
            'code' => 'unique:courses|max:4'
        ]);
  
        if($validator->fails()){//Errors in the request fields 
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //Updating fields that exists in request
        if(isset($input['name'])) $course->name = $input['name'];
        if(isset($input['code'])) $course->code = $input['code'];
        $course->update();
        return $this->sendResponse($course->toArray(), 'Course updated successfully.');        
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = course::find($id);
        if(is_null($course)){// If no course is retrieved
            return $this->sendError('Course Does Not Exist.');       
        }

        $course->delete();
        return $this->sendResponse($course->toArray(), 'Course deleted successfully.');
    }


}
