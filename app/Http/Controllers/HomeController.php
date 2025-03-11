<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\SalePrice;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::getAllProduct();
        foreach ($products as $product) {
            $product['price'] = SalePrice::getPrice($product['product_id']);
            $product['image'] = Image::getImage($product['product_id']);
            // dd($products);
        }
        $categories = Category::query()->get();
        return view("pages.components.home",
            ["products" => $products]);
    }
}
