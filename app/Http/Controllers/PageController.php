<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function __construct(
        public ProductRepository $productRepository,
        public ProductCategoryRepository $productCategoryRepository,
        public OrderRepository $orderRepository
    )
    {
    }

    public function purchasePage()
    {
        $products = $this->productRepository->getAll();
        $categories = $this->productCategoryRepository->getAll();
        return Inertia::render('Purchase', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function usersPage()
    {
        $user = auth()->user();
        $users = User::all()->except($user->id);
        return Inertia::render('Users',[
            'users' => $users
        ]);
    }


    public function dashboardPage()
    {
        $user = auth()->user();
        $user['role'] = $user->roles()->first();
        $orders = $this->orderRepository->getByUserId($user->id);
        foreach ($orders as $order){
            $order['product'] = $this->productRepository->getById($order->product_id)->name;
        }
        return Inertia::render('Dashboard',[
            'orders' => $orders
        ]);
    }
}
