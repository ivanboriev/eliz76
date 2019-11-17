<?php

namespace App\Http\Resources;

use App\Subject;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $last_subjects = Subject::where('customer_id',$this->id)->latest()->take(3)->get()  ;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'registry_number' => $this->registry_number,
            'contract_number' => $this->contract_number,
            'price' => $this->price,
            'contract_date' => $this->contract_date->format('Y-m-d'),
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'subjects' => $last_subjects

        ];
    }
}
