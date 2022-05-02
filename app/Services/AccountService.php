<?php


namespace App\Services;


use App\Mail\CreatedUser;
use App\Models\AccountSetting;
use App\Models\AssignedRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class AccountService extends Service
{
    public function generatePassword()
    {
        $characters = ['0123456789!,.[]{}()%?&*$#^<>~@|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'];
        $lengthPassword = rand(6, 20);
        $generatedPassword = '';

        for ($i = 0; $i < $lengthPassword; $i++) {
            $generatedPassword .= $characters[0][rand(0, strlen($characters[0]) - 1)];
        }

        return $generatedPassword;
    }

    public function store(array $request)
    {
        $password = $this->generatePassword();

        $user = $this->startCondition()->create([
            'login' => $request['login'],
            'email' => $request['email'],
            'password' => Hash::make($password),
            'is_admin' => false,
            'is_blocked' => false,
        ]);

        if ($user) {
            AssignedRole::create([
                'user_id' => $user->id,
                'role_id' => 2,
            ]);

            AccountSetting::create([
                'user_id' => $user->id,
                'email_notification' => true,
                'auto_logout' => false,
            ]);

            Mail::to('leosan.kiras@gmail.com')->send(new CreatedUser([
                'email' => $user->email,
                'password' => $password
            ]));

            return response()->json([
                'data' => $user,
                'message' => 'Created user'
            ], 201);
        }
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update($dataModel, array $request)
    {
        try {
            // настройки аккаунта
            $accountSettings = (new AccountSetting)->where('user_id', auth()->user()->id)->first();

            if ($accountSettings === null || $dataModel === null) {
                throw new Exception('Error account update');
            }

            // обновить модель пользователя
            $dataModel->update([
                'login' => $request['login'],
                'email' => $request['email'],
            ]);

            // обновить настройки аккаунта
            $accountSettings->update([
                'email_notification' => $request['email_notification'],
                'auto_logout' => $request['auto_logout'],
            ]);

            return response()->json(['message' => 'Account updated'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    public function destroy($dataModel)
    {
        $this->startCondition()->destroy(explode(',', $dataModel));

        return response()->json(['message' => 'User deleted'], 200);
    }
}
