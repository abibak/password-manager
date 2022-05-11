<?php

namespace App\Http\Resources;


use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class OrganizationLoginResource extends JsonResource
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
            'name' => $this->name,
            'login' => $this->login,
            'url' => $this->url,
            'tags' => $this->tags,
            'note' => Crypt::decryptString($this->note),
            'password' => Crypt::decryptString($this->password),
            'histories' => User::select('users.id', 'users.login', 'password_histories.action_text')
                ->join('password_histories', function ($join) {
                $join->on('password_histories.user_id', '=', 'users.id')
                    ->where('password_histories.login_id', $this->id);
            })->get(),
        ];
    }
}
