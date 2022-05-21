<?php

namespace App\Http\Resources;

use App\Models\AccessOrganizationFolder;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationFolderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'status' => $this->status,
            'access' => $this->access,
            'logins' => OrganizationLoginResource::collection($this->logins),
            'owner' => User::select('id', 'login')->where('id', $this->user_id)->first(),
            'users' => $this->access_users,
            'user_data' => AccessOrganizationFolder::select('users.id', 'users.login', 'access_organization_folders.access')
                ->join('organization_folders', function ($join) {
                    $join->on('access_organization_folders.organization_folder_id', '=', 'organization_folders.id')
                        ->where('access_organization_folders.organization_folder_id', $this->id);
                })->join('users', function ($join) {
                    $join->on('access_organization_folders.user_id', '=', 'users.id');
                })->get(),
        ];
    }
}
