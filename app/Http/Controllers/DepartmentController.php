<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        try {
            $departments = Department::all();
            return response(DepartmentResource::collection($departments), 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function store(Request $request)
    {
        try {
            $department = Department::create($request->all());
            return response(new DepartmentResource($department),200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function show(Department $department)
    {
        try {
            return response(new DepartmentResource($department), 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function update(Request $request, Department $department)
    {
        try {
            $department->update($request->all());
            return response(new DepartmentResource($department),200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function destroy(Department $department)
    {
        try {
            foreach ($department->employees() as $item){
                (new EmployeeController)->destroy($item['id']);
            }
            $department->delete();
            return response(['message'=>'data deleted successfully'], 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
}
