<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'surname' => $this->surname,
            'email' => $this->email,
            'city_id' => $this->city_id,
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
        ];
    }
}
