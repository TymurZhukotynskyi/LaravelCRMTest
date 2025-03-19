<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\UseCases\CreateCustomer;
use App\Domain\UseCases\DeleteCustomer;
use App\Domain\UseCases\UpdateCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    private CreateCustomer $createCustomer;

    private UpdateCustomer $updateCustomer;

    private DeleteCustomer $deleteCustomer;

    private CustomerRepository $customerRepository;

    private OrderRepository $orderRepository;

    public function __construct(
        CreateCustomer $createCustomer,
        UpdateCustomer $updateCustomer,
        DeleteCustomer $deleteCustomer,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository
    ) {
        $this->createCustomer = $createCustomer;
        $this->updateCustomer = $updateCustomer;
        $this->deleteCustomer = $deleteCustomer;
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->getAll();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $customer = $this->createCustomer->execute(
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('email')
            );

            return redirect()->route('customers.show', $customer->getId())
                ->with('success', 'Customer created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $customer = $this->customerRepository->findById($id);
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        $orders = $this->orderRepository->findByCustomerId($id);
        return view('customers.show', compact('customer', 'orders'));
    }

    public function edit(int $id)
    {
        $customer = $this->customerRepository->findById($id);
        if (!$customer) {
            abort(404, 'Customer not found');
        }
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $customer = $this->updateCustomer->execute(
                $id,
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('username', ''),
                $request->input('email'),
                $request->input('age'),
                $request->input('phone'),
                $request->input('birth_date')
            );

            return redirect()->route('customers.show', $customer->getId())
                ->with('success', 'Customer updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteCustomer->execute($id);
            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
