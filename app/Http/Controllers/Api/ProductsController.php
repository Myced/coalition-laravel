<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
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

        return response($products, 200);
    }

    public function store(Request $request)
    {
        //validate the data..
        $this->validate($request, [
            'name' => "required",
            'quantity' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        //save the product
        $data = $request->all();

        $response = [
            'success' => false,
            'message' => "",
            'item' => null,
        ];

        try {
            $product = $this->productService->addProduct($data);

            $response['item'] = $product;
            $response['success'] = true;
            $response['message'] = "Product Created";

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            $response['message'] = $errorMessage;

            return response($response, 500);
        }

        return response($response, 201);
    }
}
