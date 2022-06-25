<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var ProductService $productService
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        // dd($products);
        return view('home')->with('products', $products);
    }
}
