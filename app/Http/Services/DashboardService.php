<?php

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DashboardService {
    public function getCustomerPaginate() : Paginator {
        $customer = Customer::query()
        ->userOrderByAscWithFirstName()
        ->with('user')  
        ->simplePaginate(10);

        return $customer;
    }

    public function createOrUpdateUser(array $userData) : void {
        $userData = collect($userData);
        try {
            DB::beginTransaction();

            // Proses database
            $user = User::updateOrCreate([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
            ], $userData->only(['first_name', 'last_name', 'phone', 'account_role', 'created_at'])->toArray());

            $profile = Customer::updateOrCreate([
                'id' => $user->id,
            ], $userData->only(['address'])->toArray());

            DB::commit(); // Jika semua berhasil
            
        } catch (\Exception $e) {
            throw $e;
            DB::rollBack(); // Gagal -> rollback
        }
    }
}