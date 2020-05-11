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
            'Paged Courses List' => 'https://35.247.238.31/apicourses',
            'Full Courses List' => 'https://35.247.238.31/apicourses/all',
            'Show Course' => 'https://35.247.238.31/apicourses/{id}',
            'Create Course' => 'https://35.247.238.31/apicourses',
            'Edit Course' => 'https://35.247.238.31/apicourses/{id}',
            'Delete Course' => 'https://35.247.238.31/apicourses/{id}',
            'Paged Students List' => 'https://35.247.238.31/apistudents',
            'Full Students List' => 'https://35.247.238.31/apistudents/all',
            'Show Student' => 'https://35.247.238.31/apistudents/{id}',
            'Create Student' => 'https://35.247.238.31/apistudents',
            'Edit Student' => 'https://35.247.238.31/apistudents/{id}',
            'Delete Student' => 'https://35.247.238.31/apistudents/{id}'
        ];
            
        return $this->sendResponse($list, 'Available API routes List.');
    }

}
