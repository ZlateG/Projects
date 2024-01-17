





    <p>Hello {{ $user->name }},</p>

    <p>Welcome to our site! Your account has been created with the following credentials:</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
    <p>Please login and change your password for security reasons.</p>
    
        <a href="http://127.0.0.1:8000/login">Login </a>
    


Thanks,<br>
{{ config('app.name') }}