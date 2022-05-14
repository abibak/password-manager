<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class UserLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_folder_id' => (int)$this->user_folder_id,
            'name' => $this->name_login ?? $this->name,
            'login' => $this->login,
            'url' => $this->url,
            'tags' => $this->tags,
            'note' => Crypt::decryptString($this->note),
            'password' => Crypt::decryptString($this->password),
            'is_favorite' => (bool)$this->is_favorite,
        ];
    }
}
