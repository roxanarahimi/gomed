<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkill;
use App\Http\Requests\UpdateSkill;
use App\Http\Resources\SkillResource;
use App\Models\Skill;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $skills = Skill::all();
        try {
            return response(SkillResource::collection($skills), 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function store(StoreSkill $request)
    {
        try {
            $skill = Skill::create($request->all());
            return response(new SkillResource($skill),200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function show(Skill $skill)
    {
        try {
            return response(new SkillResource($skill), 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function update(UpdateSkill $request, Skill $skill)
    {
        try {
            $skill->update($request->all());
            return response(new SkillResource($skill),200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
    public function destroy(Skill $skill)
    {
        try {
            $skill->delete();
            return response(['message'=>'data deleted successfully'], 200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }
}
