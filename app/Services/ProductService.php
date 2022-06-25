<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Throwable;

/**
 * We will not use Laravel eloquent models since we will not be interacting with the database.
 * To make things easier we will just use arrays to store and retrieve data 
 * from the Json File.
 */
class ProductService
{
    const JSON_FILE_PATH = "data.json";
    protected $path = "";

    public function __construct()
    {
        //if the json file is not found, create it.
        $path = public_path(self::JSON_FILE_PATH);
        $this->path = $path;

        if( ! file_exists($path))
        {
            try {
                $this->createFile($path);
            } catch (\Throwable $th) {
                //handle the error creating the file here
                //leaving it empty for now.
            }
        }
    }

    private function createFile($path)
    {
        try{
            File::put($path, '');
        }
        catch(Throwable $th)
        {
            throw $th;
        }
    }

    public function getAllProducts()
    {
        $data = file_get_contents($this->path);

        if(empty($data))
            return [];

        return json_decode($data, true);
    }

    public function addProduct($productData)
    {
        $productCount = count($this->getAllProducts());

        $now = date("Y-m-d H:i:s");

        $totalValue = $productData['quantity'] * $productData['price'];

        $count = $productCount + 1;

        $productRow = [
            'count' => $count,
            'name' => $productData['name'],
            'quantity' => $productData['quantity'],
            'price' => $productData['price'],
            'submitted' => $now,
            'total_value' => $totalValue,
        ];

        try {
            $this->saveProduct($productRow);

        } catch (\Throwable $th) {
            throw $th;
        }

        return $productRow;
    }

    private function saveProduct($productRow)
    {
        //get all products 
        $products = $this->getAllProducts();

        array_push($products, $productRow);

        try {
            File::put($this->path, json_encode($products));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}