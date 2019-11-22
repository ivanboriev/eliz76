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
            'min' => $this->min,
            'max' => $this->max,
            'temp' => $this->temp,
            'atm' => $this->atm,
            'humidity' => $this->humidity,
            'contur_temp' => $this->contur_temp,
            'contur_atm' => $this->contur_atm,
            'contur_humidity' => $this->contur_humidity,
            'isolate' => $this->isolate,
            'phase' => $this->phase,
            'uzo' => $this->uzo,
            'automate' => $this->automate,
            'isolate_equip' => $this->isolate_equip,
            'phase_equip' => $this->phase_equip,
            'uzo_equip' => $this->uzo_equip,
            'automate_equip' => $this->automate_equip,
            'contur_equip' => $this->contur_equip,
            'teplovizor_equip' => $this->teplovizor_equip,
            'engineer1' => $this->engineer1,
            'engineer2' => $this->engineer2,
            'documents_generated' => $this->documents_generated,
            'documents_path' => $this->documents_path,
            'edited_documents_path' => $this->edited_documents_path,
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'created' => $this->created_at->day . ' ' . $this->created_at->locale('ru')->monthName . ' ' . $this->created_at->year
        ];
    }
}
