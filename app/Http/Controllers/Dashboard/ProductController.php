<?php
  
  namespace App\Http\Controllers\Dashboard;

  use App\Product;
  use App\Category;
  use Illuminate\Http\Request;
  use App\Http\Controllers\Controller;
  
  class ProductController extends Controller
  {
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {
          $sort_query = [];
          $sorted = "";
 
          if ($request->sort !== null) {
              $slices = explode(' ', $request->sort);
              $sort_query[$slices[0]] = $slices[1];
              $sorted = $request->sort;
          }
 
          if ($request->keyword !== null) {
              $keyword = rtrim($request->keyword);
              $total_count = Product::where('name', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->count();
              $products = Product::where('name', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->sortable($sort_query)->paginate(15);
          } else {
              $keyword = "";
              $total_count = Product::count();
              $products = Product::paginate(15);
          }
 
          $sort = [
              '価格の安い順' => 'price asc',
              '価格の高い順' => 'price desc',
              '出品の古い順' => 'updated_at asc',
              '出品の新しい順' => 'updated_at desc'
         ];

          return view('dashboard.products.index', compact('products', 'sort', 'sorted', 'total_count', 'keyword'));
      }
  
      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
          $categories = Category::all();
 
          return view('dashboard.products.create', compact('categories'));
      }
  
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          $product = new Product();
          $product->name = $request->input('name');
          $product->description = $request->input('description');
          $product->price = $request->input('price');
          $product->category_id = $request->input('category_id');
          $product->save();
 
          return redirect()->route('dashboard.products.index');
      }
  
      /**
       * Show the form for editing the specified resource.
       *
       * @param  \App\Product  $product
       * @return \Illuminate\Http\Response
       */
      public function edit(Product $product)
      {
          $categories = Category::all();
 
          return view('dashboard.products.edit', compact('product', 'categories'));
      }
  
      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  \App\Product  $product
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, Product $product)
      {
          $product->name = $request->input('name');
          $product->description = $request->input('description');
          $product->price = $request->input('price');
          $product->category_id = $request->input('category_id');
          $product->update();
 
          return redirect()->route('dashboard.products.index');
      }
  
      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Product  $product
       * @return \Illuminate\Http\Response
       */
      public function destroy(Product $product)
      {
          $product->delete();
 
          return redirect()->route('dashboard.products.index');
      }
  }