<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest;
use App\Http\Services\DashboardService;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller
{
    private DashboardService $dashboardImpl;
    public function __construct(DashboardService $dashboardImpl) {
        $this->dashboardImpl = $dashboardImpl;
    }

    public function index(Request $request) : View | string {
        $user = auth()->user();
        $customersPaginate = $this->dashboardImpl->getCustomerPaginate();
        if ($request->ajax()) {
            return view('dashboard.datatables.index', compact('customersPaginate'))->render();
        }
        return view('dashboard', compact('user', 'customersPaginate'));
    }

    public function getCustomerPaginate() : string {
        $customersPaginate = $this->dashboardImpl->getCustomerPaginate();
        return view('dashboard.datatables.index', compact('customersPaginate'))->render();
    }

    public function action(ActionRequest $request) : JsonResponse {
        try {
            $this->dashboardImpl->createOrUpdateUser($request->validated());
            return response()->json([
                'data' => $request->validated()
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => $th->getMessage()
            ], 403);
        }
    }

    public function getCustomerById(Request $request) : Customer {
        $customer = Customer::find($request->id);
        return $customer;
    }
}
