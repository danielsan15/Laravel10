<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {

         // Assign only to ONE method in this Controller
         $this->middleware('can:categories.index')->only('index');
         $this->middleware('can:categories.create')->only(['create', 'store']);
         $this->middleware('can:categories.edit')->only(['edit', 'update']);
         $this->middleware('can:categories.destroy')->only('destroy');


     }
    public function index()
    {
        //

        $categories=Category::orderBy('id','desc')
        ->simplePaginate(8);

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view ('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {




        $category = $request->all();

        if ($request->hasFile('image')){

            $category['image']=$request->file('image')->store('categories');
        }

        Category::create($category);

        return redirect()->action([CategoryController::class,'index'])
        ->with('success-create','Categoria creado con exito');
       // return redirect('dashboard')->with('status', 'Profile updated!');





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //
        //si el usuario sube nueva image

        if ($request->hasFile('image')){
            //Elimianr image
            File::delete(public_path('storage/'.$category->image));
            // asignar nueva foto
            //$category=$request['image']->store('categories');
            $category['image']=$request->file('image')->store('categories');
        }
        //Actulizar datos
        $category->update([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'is_featured'=>$request->is_featured,
            'status'=>$request->status,

        ]);

        return redirect()->action([CategoryController::class,'index'])
        ->with('success-update','Categoria modificado con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //

        if ($category->image){
            //Elimianr image
            File::delete(public_path('storage/'.$category->image));

        }
        // Eliminar articulo

        $category->delete();
        return redirect()->action([CategoryController::class,'index'])
        ->with('success-delete','Categoria eliminado con exito');
    }

    // filtrar articulos por categoria

    public function detail(Category $category){

        $this->authorize('published', $category);

        $articles = Article::where([
            ['category_id',$category->id],
            ['status','1']
        ])
        ->orderBy('id','desc')
        ->simplePaginate(5);

         // obtner las categorias

         $navbar = Category::where([
            ['status','1'],
            ['is_featured','1'],
        ])->paginate(3);

        return view('subscriber.categories.detail',compact('articles','category','navbar'));
    }
}
