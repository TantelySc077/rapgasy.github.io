<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update the admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'sch77@gmail.com';
        $password = 'Tantely1234';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($password),
                'role' => 'admin'
            ]);
            $this->info("User $email updated to Admin.");
        } else {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin'
            ]);
            $this->info("User $email created as Admin.");
        }
    }
}
