<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        /*return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'photo' => $this->photo,
            'Telephone' => $this->Telephone,
            'Date_naissance' => $this->Date_naissance,
            'Cin' => $this->Cin,
            'Active' => $this->Active,
            'Sex' => $this->Sex,
            'role' => $this->role,
            'Email' => $this->Email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];*/

        
    }
}
