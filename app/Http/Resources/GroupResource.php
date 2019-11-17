<?php

namespace App\Http\Resources;

use App\Cable;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cable = Cable::find($this->cable_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'consumer' => $this->consumer,
            'cable'=> $cable,
            'automate_name' => $this->automate_name,
            'automate_category' => $this->automate_category,
            'automate_nominal' => $this->automate_nominal,
            'enter' => $this->enter,
            'diff' => $this->diff,
            'pred' => $this->pred,
            'uzo' => $this->uzo,
            'numerable' => $this->numerable
        ];
    }
}
