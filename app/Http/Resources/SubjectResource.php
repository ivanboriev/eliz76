<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'address' => $this->address,
            'photo_path' => $this->photo_path,
            'temp' => $this->temp,
            'atm' => $this->atm,
            'humidity' => $this->humidity,
            'isolate' => $this->isolate,
            'phase' => $this->phase,
            'uzo' => $this->uzo,
            'automate' => $this->automate,
            'engineer1' => $this->engineer1,
            'engineer2' => $this->engineer2,
            'documents_generated' => $this->documents_generated,
            'documents_path' => $this->documents_path,
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'created' => $this->created_at->day.' '.$this->created_at->locale('ru')->monthName.' '.$this->created_at->year
        ];
    }
}
