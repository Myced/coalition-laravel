<?php
namespace App\Services;

use Exception;
use Throwable;
use Illuminate\Support\Facades\File;

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

    /**
     * @param string|int $productId
     * @throws Exception
     * @return array
     */
    public function getProductById($productId)
    {
        //the only way to get a get  a product is to loop through all items
        //and return the one that the count matches the productId.
        $products = $this->getAllProducts();

        foreach($products as $product)
        {
            if($product['count'] == $productId)
                return $product;
        }

        //if we reach here, it means the product is not found
        //throw an exception 
        throw new Exception("Product Not Found");
    }

    public function updateProduct($productData, $productId)
    {
        // $product = $this->getProductById($productId);

        $products = $this->getAllProducts();

        foreach($products as &$product)
        {
            if($product['count'] == $productId)
            {
                $product['name'] = $productData['name'];
                $product['quantity'] = $productData['quantity'];
                $product['price'] = $productData['price'];
            }
        }

        //now save the products.
        $this->saveToFile($products);
    }

    private function saveProduct($productRow)
    {
        //get all products 
        $products = $this->getAllProducts();

        array_push($products, $productRow);

        $this->saveToFile($products);
    }

    private function saveToFile($products)
    {
        try {
            File::put($this->path, json_encode($products));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}