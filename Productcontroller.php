<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductRating;

use App\Models\Category;
use Illuminate\View\View;

use DB;



class Productcontroller extends Controller
{

  
     public function index(Request $request) {
         // Start with the query builder
         $product = Product::select('products.*')
             ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
             ->leftJoin('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
             ->leftJoin('brands', 'brands.id', '=', 'products.brand_id');
            
     
         // Check if a keyword is provided in the request
         if ($request->has('keyword') && !empty($request->keyword)) {
             $keyword = $request->keyword;
             $product->where(function ($query) use ($keyword) {
                 $query->where('products.title', 'like', '%' . $keyword . '%')
                  
                     ->orWhere('categories.name', 'like', '%' . $keyword . '%')
                     ->orWhere('subcategories.name', 'like', '%' . $keyword . '%')
                     ->orWhere('brands.name', 'like', '%' . $keyword . '%');
                 // Add more fields to search as needed
             });
         }
     
         // Paginate the results
         $product = $product->paginate(10);
     
         // Return the view with the paginated products
         return view('admin.product.index', compact('product'));
     }
     

    public function create()
     {
        
        $category = Category::get();
        $subcategory = Subcategory::get();
        $brand = Brand::get();

        $data['category'] =$category;
        $data['subcategory'] =$subcategory;
        $data['brand'] =$brand;
        return view ('admin.product.create',$data);
    
        
     }
     public function store(Request $request)
     {
         $rules = [
             'title' => 'required',
             'price' => 'required|numeric',
             'track_qty' => 'required|in:yes,no',
             'sku' => 'required|unique:products',
             'is_featured' => 'nullable|in:yes,no',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
             'category_id' => 'required', // Adjust as per your validation rules
             'subcategory_id' => 'required', // Adjust as per your validation rules
             'brand_id' => 'required', // Adjust as per your validation rules
         ];
     
         $validator = Validator::make($request->all(), $rules);
     
         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }
     
         $product = new Product;
         $product->title = $request->title;
         $product->slug = $request->slug; // Make sure you handle slug generation properly if not provided by user
         $product->category_id = $request->category_id;
         $product->subcategory_id = $request->subcategory_id;
         $product->brand_id = $request->brand_id;
         $product->price = $request->price;
         $product->sku = $request->sku;
         $product->status = $request->status ?? 0; // Default status if not provided
         $product->is_featured = $request->is_featured ?? 'no'; // Default is_featured if not provided
         $product->qty = $request->qty;
         $product->description = $request->description;
         $product->shipping_returns = $request->shipping_returns;
         $product->related_products = implode(',', $request->related_products ?? []);
     
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $imageName = time() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('images'), $imageName);
             $product->image = $imageName;
         }
     
         $product->save();
     
         return redirect('admin/product/index')->with('success', 'Product has been created successfully.');
     }
   
    public function edit(string $id): View
       {
        $relatedproducts = [];
           $product = Product::find($id);   //SELECT QUERY
           
           $category = Category::get();
           $subcategory = Subcategory::get();
           $brand = Brand::get();

            if($product->related_products!= ''){
                $productArray = explode(',',$product->related_products);
                $relatedproducts = Product::whereIn('id',$productArray)->get();
                
            }
   
           $data['category'] =$category;
           $data['subcategory'] =$subcategory;
           $data['brand'] =$brand;
           $data['product'] =$product; 
           $data['relatedproducts'] =$relatedproducts; 
           return view('admin.product.create',$data);
       }
       


       public function update(Request $request, $id)
       {
           $product = Product::findOrFail($id);
       
           $rules = [
               'title' => 'required',
               'slug' => 'required|unique:products,slug,' . $id,
               'price' => 'required|numeric',
               'track_qty' => 'required|in:yes,no',
               'sku' => 'required|unique:products,sku,' . $id,
               'is_featured' => 'nullable|in:yes,no',
               'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
               'category_id' => 'required', // Adjust as per your validation rules
               'subcategory_id' => 'required', // Adjust as per your validation rules
               'brand_id' => 'required', // Adjust as per your validation rules
           ];
       
           if ($request->has('track_qty') && $request->track_qty == 'yes') {
               $rules['qty'] = 'required|numeric';
           }
       
           $validator = Validator::make($request->all(), $rules);
       
           if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
           }
       
           $product->title = $request->title;
           $product->slug = $request->slug; // Make sure you handle slug generation properly if not provided by user
           $product->category_id = $request->category_id;
           $product->subcategory_id = $request->subcategory_id;
           $product->brand_id = $request->brand_id;
           $product->price = $request->price;
           $product->sku = $request->sku;
           $product->status = $request->status ?? 0; // Default status if not provided
           $product->is_featured = $request->is_featured ?? 'no'; // Default is_featured if not provided
           $product->qty = $request->qty;
           $product->description = $request->description;
           $product->shipping_returns = $request->shipping_returns;
           $product->related_products = implode(',', $request->related_products ?? []);
       
           if ($request->hasFile('image')) {
               $image = $request->file('image');
               $imageName = time() . '.' . $image->getClientOriginalExtension();
               $image->move(public_path('images'), $imageName);
               $product->image = $imageName;
           }
       
           $product->save();
       
           return redirect('admin/product/index')->with('success', 'Product has been updated successfully.');
       }
       
      public function delete($id): RedirectResponse
      {
          $product = Product::find($id);  //SELECT QUERY 
          if ($product)
           {

            $product->delete();
            return redirect('admin/product/index')->with(['success'=> 'Successfully deleted!!']);
        } else {
            return redirect('admin/product/index')->with(['error'=> 'Product not found!!']);
        }
      }

    public function getSubCat(Request $request)
      { 
        $cid = $request->cid;
        $subcategory = Subcategory::with('category')->where('category_id',$cid)->get();
        return response()->json($subcategory);

    }

   public function changeStatus(Request $request) {
  
    $data = $request->all();    

    $product = Product::find($data['id']);

    if ($product->status) {
        $product->status = 0;
    } else {
        $product->status = 1;
    }

    $product->save();

    $array = array();
    $array['status'] = $product->status;
    $array['success'] = true;
    $array['message'] = 'Status changed successfully!';
    echo json_encode($array);
}
    public function getproducts(Request $request)
    {
        $tempProduct = [];
        if($request->term!= ""){
            $products = Product::where('title','like','%'.$request->term.'%')->get();
            if($products!= null){
               foreach($products as $product){
                $tempProduct[] = array('id' => $product->id,
                                         'text'=>$product->title);
                  
               }
            }
        }
      return response()->json([
        'tags'=>$tempProduct,
        'status' =>true
      ]);
    }

// product ratings

    public function Ratingindex(Request $request){
        $productratings =  ProductRating::select('product_ratings.*','products.title as productTitle')
            ->orderBy('product_ratings.created_at', 'DESC')
            ->leftJoin('products', 'products.id','product_ratings.product_id');
        

            

             if ($request->filled('keyword')) {
    $keyword = $request->input('keyword');

    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
    
        $productratings->where('products.title', 'like', '%' . $keyword . '%')
            ->orWhere('product_ratings.username', 'like', '%' . $keyword . '%');
    }
}

            $productratings = $productratings->paginate(8);

            return view('admin.product.rating', compact('productratings'));
        }



    
public function ratingStatus(Request $request) {
  
    $data = $request->all();    

    $rating = ProductRating::find($data['id']);

    if ($rating->status) {
        $rating->status = 0;
    } else {
        $rating->status = 1;
    }

    $rating->save();

    $array = array();
    $array['status'] = $rating->status;
    $array['success'] = true;
    $array['message'] = 'Status changed successfully!';
    echo json_encode($array);
}




}
// https://anayadesignerstudio.com/
// Unstitched-Stitched-Half-Saree-for-south-indian-wedding-banner-scaled  