<?php

namespace App\Repositories;

use App\Models\AccountSetting;
use App\Models\User as Model;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function getAllUsers()
    {
        return $this->startCondition()->select('*')
            ->with('assigned_roles', function ($query) {
                $query->select('id', 'user_id', 'role_id')->with('role');
            })->get();
    }

    public function getUserById(int $id)
    {
        return $this->startCondition()->where('id', $id)->first();
    }

    public function getPasswordCurrentUser()
    {
        return $this->startCondition()::select('password')
            ->find(auth()->user()->id)
            ->makeVisible('password');
    }

    public function updatePasswordCurrentUser(string $password)
    {
        return $this->startCondition()->where('id', auth()->user()->id)->update([
           'password' => Hash::make($password),
        ]);
    }

    public function getLogins()
    {
        return $this->startCondition()
            ->select('id', 'login')
            ->where('is_deactivate', '!=', true)->where('is_blocked', '!=', true)
            ->orderBy('id')
            ->get();
    }

    public function getUserByEmail(string $email)
    {
        return $this->startCondition()->where('email', $email)
            ->with('settings', function ($query) {
                $query->select('user_id', 'email_notification', 'auto_logout');
            })->first();
    }

    public function getUserEdit()
    {
        return $this->startCondition()->where('id', auth()->user()->id)->first();
    }

    public function getUserSettings()
    {
        return AccountSetting
            ::select('email_notification', 'auto_logout')
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
