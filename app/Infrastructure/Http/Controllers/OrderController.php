<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderStatusRepository;
use App\Domain\UseCases\CreateOrder;
use App\Domain\UseCases\DeleteOrder;
use App\Domain\UseCases\GetOrderDetails;
use App\Domain\UseCases\GetOrderList;
use App\Domain\UseCases\UpdateOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    private CreateOrder $createOrder;

    private UpdateOrder $updateOrder;

    private DeleteOrder $deleteOrder;

    private GetOrderList $getOrderList;

    private OrderRepository $orderRepository;

    private CustomerRepository $customerRepository;

    private OrderStatusRepository $orderStatusRepository;

    private GetOrderDetails $getOrderDetails;

    public function __construct(
        CreateOrder $createOrder,
        UpdateOrder $updateOrder,
        DeleteOrder $deleteOrder,
        GetOrderList $getOrderList,
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        OrderStatusRepository $orderStatusRepository,
        GetOrderDetails $getOrderDetails
    ) {
        $this->createOrder = $createOrder;
        $this->updateOrder = $updateOrder;
        $this->deleteOrder = $deleteOrder;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->getOrderList = $getOrderList;
        $this->getOrderDetails = $getOrderDetails;
    }

    public function index(Request $request): View
    {
        $statusId = $request->query('status_id') ? (int) $request->query('status_id') : null;
        $orders = $this->getOrderList->execute($statusId);
        $statuses = $this->orderStatusRepository->getAll();
        return view('orders.index', compact('orders', 'statusId', 'statuses'));
    }

    public function create(Request $request): View
    {
        $customers = $this->customerRepository->getAll();
        $preselectedCustomerId = $request->query('customer_id');

        $statuses = $this->orderStatusRepository->getAll();

        return view('orders.create', compact('customers', 'preselectedCustomerId', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $order = $this->createOrder->execute($request->input('customer_id'), $request->input('status_id'));
            return redirect()->route('orders.show', $order->getId())
                ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(int $id): View
    {
        $orderDetails = $this->getOrderDetails->execute($id);
        return view('orders.show', compact('orderDetails'));
    }

    public function edit(int $id): View
    {
        $order = $this->orderRepository->findById($id);
        if (!$order) {
            abort(404, 'Order not found');
        }
        $customer = $this->customerRepository->findById($order->getCustomerId());
        $statuses = $this->orderStatusRepository->getAll();
        return view('orders.edit', compact('order', 'customer', 'statuses'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $customer = $this->customerRepository->findById($request->input('customer_id'));
            if (!$customer) {
                throw new \Exception("Customer with username {$request->input('username')} not found.");
            }

            $order = $this->updateOrder->execute(
                $id,
                $customer->getId(),
                $request->input('status_id'),
                (float) $request->input('total_amount'),
                (int) $request->input('total_products')
            );

            return redirect()->route('orders.show', $order->getId())
                ->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->deleteOrder->execute($id);
            return redirect()->route('orders.index')
                ->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
