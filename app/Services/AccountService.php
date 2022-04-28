<?php


namespace App\Services;


use App\Models\AccountSetting;
use Mockery\Exception;

class AccountService extends Service
{
    public function store(array $request)
    {
        // TODO: Implement store() method.
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update($dataModel, array $request)
    {
        try {
            $accountSettings = (new AccountSetting)->where('user_id', auth()->user()->id)->first();

            if ($accountSettings === null || $dataModel === null) {
                throw new Exception('Error account update');
            }

            $dataModel->update([
                'login' => $request['login'],
                'email' => $request['email'],
            ]);

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
        // TODO: Implement destroy() method.
    }
}
