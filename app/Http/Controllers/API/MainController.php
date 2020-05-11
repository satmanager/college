<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = [
            'API List' => 'https://35.247.238.31/api/',  
            'Token for Auth' => 'https://35.247.238.31/api/token',            
            'Paged Courses List' => 'https://35.247.238.31/api/courses',
            'Full Courses List' => 'https://35.247.238.31/api/courses/all',
            'Show Course' => 'https://35.247.238.31/api/courses/{id}',
            'Create Course' => 'https://35.247.238.31/api/courses',
            'Edit Course' => 'https://35.247.238.31/api/courses/{id}',
            'Delete Course' => 'https://35.247.238.31/api/courses/{id}',
            'Paged Students List' => 'https://35.247.238.31/api/students',
            'Full Students List' => 'https://35.247.238.31/api/students/all',
            'Show Student' => 'https://35.247.238.31/api/students/{id}',
            'Create Student' => 'https://35.247.238.31/api/students',
            'Edit Student' => 'https://35.247.238.31/api/students/{id}',
            'Delete Student' => 'https://35.247.238.31/api/students/{id}'
        ];
            
        return $this->sendResponse($list, 'Available API routes List.');
    }

}
