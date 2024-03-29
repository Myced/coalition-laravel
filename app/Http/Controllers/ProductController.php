<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductService $productService
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;     
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
        $data = $request->except('_token');

        try {
            $this->productService->addProduct($data);

            session()->flash('success', 'Product Save successfully');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            session()->flash('error', $errorMessage);
        }

        return back();
    }

    public function edit(Request $request, $productId)
    {
        try {
            $product = $this->productService->getProductById($productId);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            session()->flash('error', $errorMessage);
            return back();
        }

        return view('product_edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        //validate the data..
        $this->validate($request, [
            'name' => "required",
            'quantity' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        try {
            $this->productService->updateProduct($request->all(), $productId);
            session()->flash('success', 'Product Updated');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->home();
    }
}
