<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeSkill;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $employees = Employee::all();
        try {
            return response(EmployeeResource::collection($employees), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function uploadImage($base64_str, $name, $folderPath)
    {
        $image_parts = explode(";base64,", $base64_str);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . $name . '.' . $image_type;
        file_put_contents($file, $image_base64);
        return $name . '.' . $image_type;
    }

    public function store(StoreEmployee $request)
    {
        try {
            $employee = Employee::create($request->except('skill_ids', 'percentages', 'image'));
            $imageName = $this->uploadImage($request['image'], $employee['id'] . '_' . uniqid(), 'images/');
            $employee->update(['image'=> $imageName]);

            for ($i = 0; $i < count(explode(',',$request['skill_ids'])); $i++) {
                EmployeeSkill::create([
                    'employee_id' => $employee['id'],
                    'skill_id' => (integer)explode(',',$request['skill_ids'])[$i],
                    'percentage' => (integer)explode(',',$request['percentages'])[$i],
                ]);
            }

            return response(new EmployeeResource($employee), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Employee $employee)
    {
        try {
            return response(new EmployeeResource($employee), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function update(UpdateEmployee $request, Employee $employee)
    {
        try {
            $employee->update($request->except('skill_ids', 'percentages', 'image'));
            if ($request['image']){
                $imagePath = $this->uploadImage($request['image'], $employee['id'] . '_' . uniqid(), 'images/');
                $employee->update(['image', $imagePath]);
            }
            $employee->skills()->each->delete();
            for ($i = 0; $i < count(explode(',',$request['skill_ids']))-2; $i++) {
                EmployeeSkill::create([
                    'employee_id' => $employee['id'],
                    'skill_id' => $request['skill_ids'][$i],
                    'percentage' => $request['percentages'][$i],
                ]);
            }

            return response(new EmployeeResource($employee)
                , 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Employee $employee)
    {

        try {
            $employee->skills()->each->delete();
            $employee->delete();
            return response(['message' => 'data deleted successfully'], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
}
