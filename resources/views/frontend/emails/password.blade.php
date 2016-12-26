<!-- resources/views/emails/password.blade.php -->
Click here to reset your password: {{ route('auth.password.reset', $token) }}