<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return ClassesResource::collection($classes);
    }
}
