<?php
  
  namespace App\Http\Controllers\Dashboard;

  use App\Category;
  use Illuminate\Http\Request;
  use App\Http\Controllers\Controller;

  class CategoryController extends Controller
  {
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
          $categories = Category::paginate(15);

          return view('dashboard.categories.index', compact('categories'));
      }
  
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          $category = new Category();
          $category->name = $request->input('name');
          $category->description = $request->input('description');
          $category->major_category_name = $request->input('major_category_name');
          $category->save();

          return redirect("/dashboard/categories");
      }
  
      /**
       * Display the specified resource.
       *
       * @param  \App\Category  $category
       * @return \Illuminate\Http\Response
       */
      public function show(Category $category)
      {
          //
      }
  
      /**
       * Show the form for editing the specified resource.
       *
       * @param  \App\Category  $category
       * @return \Illuminate\Http\Response
       */
      public function edit(Category $category)
      {
          return view('dashboard.categories.edit', compact('category'));
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  \App\Category  $category
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, Category $category)
      {
          $category->name = $request->input('name');
          $category->description = $request->input('description');
          $category->major_category_name = $request->input('major_category_name');
          $category->update();
 
          return redirect("/dashboard/categories");
      }
  
      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Category  $category
       * @return \Illuminate\Http\Response
       */
      public function destroy(Category $category)
      {
          $category->delete();
 
          return redirect("/dashboard/categories");
      }
  }