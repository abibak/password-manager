<?php


namespace App\Services;


use App\Mail\CreatedUser;
use App\Models\AccountSetting;
use App\Models\AssignedRole;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class AccountService extends Service
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

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

        $user = User::create([
            'login' => $request['login'],
            'email' => $request['email'],
            'password' => Hash::make($password),
            'is_admin' => $request['is_admin'],
        ]);

        if ($user) {
            // Назначить роль
            AssignedRole::create([
                'user_id' => $user->id,
                'role_id' => $request['role_id'],
            ]);

            // Определить базовые настройки аккаунта
            AccountSetting::create([
                'user_id' => $user->id,
                'email_notification' => true,
                'auto_logout' => false,
            ]);

            // Отправка уведомления на почту
            Mail::to('leosan.kiras@gmail.com')->queue((new CreatedUser([
                'email' => $user->email,
                'password' => $password
            ])));

            return response()->json([
                'data' => $this->userRepository->getUserByEmail($user->email),
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
        User::destroy(explode(',', $dataModel));
        return response()->json(['message' => 'User deleted'], 200);
    }

    public function changeStatusDeactivateAccount(int $id)
    {
        $user = $this->userRepository->getUserById($id);
        $statusDeactivate = $user->is_deactivate;

        if ($statusDeactivate) {
            $statusDeactivate = false;
            $message = 'User activated';
        } else {
            $statusDeactivate = true;
            $message = 'User deactivated';
        }

        $user->update([
            'is_deactivate' => $statusDeactivate,
        ]);

        return response()->json([
            'data' => $user,
            'message' => $message
        ],200);
    }

    public function changeStatusBlockedAccount(int $id)
    {
        $user = $this->userRepository->getUserById($id);
        $statusBlocked = $user->is_blocked;

        if ($statusBlocked) {
            $statusBlocked = false;
            $message = 'User unblocked';
        } else {
            $statusBlocked = true;
            $message = 'User blocked';
        }

        $user->update([
            'is_blocked' => $statusBlocked,
        ]);

        return response()->json([
            'data' => $user,
            'message' => $message
        ],200);
    }
}
