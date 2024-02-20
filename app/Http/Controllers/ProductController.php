<?php

namespace App\Http\Controllers;

use App\Support\Storage\Contract\StorageInterface;
use App\Models\Product;
use App\Support\Basket\Basket;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // $sessionStorage = resolve(StorageInterface::class);

        // $sessionStorage->set('item', 5);
        // $sessionStorage->set('id', 5);
        // $sessionStorage->unset('id');
        // // dd($sessionStorage->exist('item'));
        // dd($sessionStorage->count());
        // // dd($sessionStorage->get('id'));
        // dd($sessionStorage->all());
        // dd(session()->all());

        $products = Product::all();

        return view('products', compact('products'));
    }
}
