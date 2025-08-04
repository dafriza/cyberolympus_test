<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Generate cyberolympus admin');
        $user = User::query()->where('email', 'like', '%admin@cyberolympus.com%')->first();
        
        if(isset($user)) {
            $this->command->alert('User has been generated');
        }else {
            $email = 'admin@cyberolympus.com';
            $password = 'cyberadmin';
            $passwordHash = Hash::make($password);
            
            User::create([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => $email,
                'password' => $password,
                'account_type' => 1,
                'account_role' => User::IS_SUPERADMIN
            ]);
        }

        $this->command->info('Success generate admin account');
    }
}
