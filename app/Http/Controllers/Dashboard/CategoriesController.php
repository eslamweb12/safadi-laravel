<?php

namespace App\Http\Controllers\Dashboard;
// namespace App\Models;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('categories.view')){
            return abort(403);
        }
        $request= request();
        // $query=Category::query();

        $categories = Category::with('parent')
        // leftJoin('categories as parents','parents.id','=','categories.parent_id')
        // ->select([
        //     'categories.*',
        //     'parents.name as parent_name'
        // ])
        ->withCount([
            'products as products_number'=>function($query){
                $query->where('status','=','active');


            }
        ])
        ->filter($request->query())
        ->orderBy('categories.name')
        ->paginate(); 
         //return a collection class
       return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('categories.view')){
            return abort(403);
        }
        $parents= category::all();  
        $category=new category();
       return view('dashboard.categories.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');
       $clean_data= $request->validate(category::rules(),[
            'requierd'=>'This is field(:attribute) is required',
            'unique'=>'This name already exists',
        ]);

        $request->merge([
            'slug'=>Str::slug($request->post('name'))
        ]);
        $data=$request->except('image');
        if($request->hasFile('image')){
            $file=$request->file('image');
            $path=$file->store('uploads',[
                'disk'=>'public'
            ]);
           
            $data['image']=$path; 

        }
        


        $category=category::create($data);
        return Redirect::route('dashboard.categories.index')
        ->with('success','category created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if(!Gate::allows('categories.view')){
            return abort(403);
        }
        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('categories.update');
        try{
            $category=Category::findOrFail($id);

        }catch(Exception $e){
            return redirect ()->route('dashboard.categories.index')
            ->with('info','Record not found!');

        }
        // $category=category::find($id);
        $parents = Category::where('id','<>', $id)
        ->where(function($query) use ($id) {
            $query->whereNull('parent_id')
                  ->orWhere('parent_id', '<>', $id);
        })
        ->get();

       

        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        // $request->validate(category::rules($id));

     
        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data=$request->except('image');
        // if($request->hasFile('image')){
        //     $file=$request->file('image');
        //     $path=$file->store('uploads',[
        //         'disk'=>'public'
        //     ]);

        //     $data['image']=$path; 

        // } 
        $new_image=$this->uploadImage($request);
        if($new_image){
            $data['image']=$new_image;
        }
        


        $category->update($data); 
        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }



        return Redirect::route('dashboard.categories.index')
        ->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('categories.delete');
        $category= category::findOrFail($id);
        $category->delete();
      //or
     //2- category::where('id','=',$id)->delete();  or

        // category::destroy('$id');
        // if($category->image){
        //     Storage::disk('public')->delete($category->image);
        // }
        return Redirect::route('dashboard.categories.index');
        with('success','category deleted');
     
    }
    protected function uploadImage(Request $request)
    {
        if(!$request->hasFile('image'))
        {
            return;
        }

        $file = $request->file('image'); // UploadeFile object
        // $file->getClientOriginalName();// The original name for image
        // $file->getSize();// Get size of image per pic
        // $file->getClientOriginalExtension();// Return file exctension
        // $file->getMimeType();//Return type of file

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;

    }
    public function trash(){
        $categories=Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }
    public function restore(Request $request,$id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')
        ->with('success','Category restores!');
    }
    public function forceDelete($id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
         if($category->image){
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')
        ->with('success','Category deleted forever!');
    }
}

