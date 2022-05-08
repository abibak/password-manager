@component('mail::message')
# Приветствуем

Вы были добавлены в систему менеджера паролей. <br>
Ваши данные используемые для входа в систему:

## Email: {{ $data['email'] }}
## Пароль: {{ $data['password'] }}

@component('mail::button', ['url' => 'localhost:8080'])
    Вход
@endcomponent

Password manager, <br>
Студия Т.
@endcomponent
