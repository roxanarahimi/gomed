<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $skills = [];
        foreach ($this->skills as $item) {
            array_push($skills, ['name' => $item->skill->name, 'percentage' => $item->percentage]);
        }

        return [
            'id' => (string)$this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'image' => '/images/' . $this->image,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
                'description' => $this->department->description
            ],
            'skills' => $skills,
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
