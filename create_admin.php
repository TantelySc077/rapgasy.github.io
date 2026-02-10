<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'sch77@gmail.com';
$password = 'Tantely1234';

$user = User::where('email', $email)->first();

if ($user) {
    $user->update([
        'password' => Hash::make($password),
        'is_admin' => true
    ]);
    echo "User $email updated to Admin.\n";
} else {
    User::create([
        'name' => 'Admin',
        'email' => $email,
        'password' => Hash::make($password),
        'is_admin' => true
    ]);
    echo "User $email created as Admin.\n";
}
