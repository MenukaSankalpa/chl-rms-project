<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoyageResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'code'=> $this->code,
            'eta'=> $this->eta,
            'option_element' => '<option value=\''.$this->id.'\'>'.$this->code.'</option>'
        ];
    }
}
