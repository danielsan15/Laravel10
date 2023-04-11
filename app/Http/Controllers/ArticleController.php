<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        // Assign only to ONE method in this Controller
        $this->middleware('can:articles.index')->only('index');
        $this->middleware('can:articles.create')->only(['create', 'store']);
        $this->middleware('can:articles.edit')->only(['edit', 'update']);
        $this->middleware('can:articles.destroy')->only('destroy');


    }
    public function index()
    {

       // $user= Auth::user()->id;
        $articles=Article:://where('user_id',$user)
        orderBy('id','desc')
        ->simplePaginate(10);

        return view('admin.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtner categorias publicas

        $categories=Category::select(['id','name'])
        ->where('status','1')
        ->get();

        return view('admin.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //
        $request->merge([
            'user_id'=>Auth::user()->id,
        ]);


        $article = $request->all();

        if ($request->hasFile('image')){

            $article['image']=$request->file('image')->store('articles');
        }

        Article::create($article);

        return redirect()->action([ArticleController::class,'index'])
        ->with('success-create','Articulo creado con exito');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $comments= $article->comments()->simplePaginate(5);
        return view('subscriber.articles.show',compact('article','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
        $this->authorize('view',$article);
        $categories=Category::select(['id','name'])
        ->where('status','1')
        ->get();

        return view('admin.articles.edit',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        //si el usuario sube nueva image
        $this->authorize('update',$article);
        if ($request->hasFile('image')){
            //Elimianr image
            File::delete(public_path('storage/'.$article->image));
            // asignar nueva foto
            $article['image']=$request->file('image')->store('articles');
           // $article=$request['image']->store('articles');
        }
        //Actualizar datos
        $article->update([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'introduction'=>$request->introduction,
            'body'=>$request->body,
            'user_id'=>Auth::user()->id,
            'category_id'=>$request->category_id,
            'status'=>$request->status,

        ]);
        return redirect()->action([ArticleController::class,'index'])
        ->with('success-update','Articulo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //Eliminar imagen

        $this->authorize('delete',$article);
        if ($article->image){
            //Elimianr imagedelete
            File::delete(public_path('storage/'.$article->image));

        }
        // Eliminar articulo

        $article->delete();
        return redirect()->action([ArticleController::class,'index'])
        ->with('success-delete','Articulo eliminado con exito');
    }
}
