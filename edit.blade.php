{{-- @extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
            <section class="content-header">					
					<div class="container-fluid my-2">	
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{route('product.index')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->


	<div class="container-fluid">

					{{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    {{-- @include('admin.message')
                <form action="{{url('admin/product/update/'.$product->id)}}" method="POST" id="categoryForm" name="categoryForm"  enctype="multipart/form-data">
                    @csrf					
					<div class="row">
						
                            <div class="col-md-8">
								
                                <div class="card mb-3">
                                    <div class="card-body">								
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title"   value ="{{old('title',$product->title)}}" class="form-control" placeholder="Title">	
                                                </div>
                                            </div>

											<div class="col-md-12">
                                                <div class="mb-3">
												     <label for="price">Price</label>
											           <input type="number"   name="price" id="price" value ="{{old('price',$product->price)}}" class="form-control" >	
										      </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
												<label for="description">Description</label>
											     <input type="text"   name="description" id="description" value ="{{old('description',$product->description)}}"class="form-control" >	
										        </div>
                                            </div> 

											<div class="col-md-12">
                                                <div class="mb-3">
												<label for="shipping_returns">shipping_returns</label>
											     <input type="text"   name="shipping_returns" id="shipping_returns" value ="{{old('shipping_returns',$product->shipping_returns)}}" class="form-control" >	
										       </div>
                                            </div>

                                        </div>
                                    </div>	                                                                      
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Media</h2>								
										<div class="col-md-6">
										<div class="mb-3">
                                        <input type="file" name="image" class="form-control" placeholder="image">
											<img src="/images/{{ $product->image }}" width="300px">
										</div>
									</div>
                                    </div>	                                                                      
                                </div>


                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Inventory</h2>								
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">Slug</label>
                                                    <input type="text"   name="slug" id="slug" value ="{{old('slug',$product->slug)}}" class="form-control" placeholder="Slug">	
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">Sku</label>
                                                    <input type="text" name="sku" id="sku"  value ="{{old('sku',$product->sku)}}" class="form-control" placeholder="sku">	
                                                </div>
                                            </div>   
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="hidden" name="track_qty" value="no">
                                                        <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="yes"checked>
                                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="qty" id="qty"  value ="{{old('qty',$product->qty)}}"  class="form-control" placeholder="Qty">	
                                                </div>
                                            </div>    
                                            
                                                            
                                         

                                        </div>
                                    </div>	 
                                                                                                
                                </div>
                                                    <div class="card mb-3">
                                                        <div class="card-body">	
                                                            <h2 class="h4 mb-3">Related Products
                                                                <p class="error"></p>
                                                            </h2>
                                                            <div class="mb-3">
                                                                <select multiple class="form-control related_product w-100" name ="related_products[]" id="related_products">
                                                                @if(!empty($relatedproducts))
                                                                    @foreach($relatedproducts as $relproduct)
                                                                    <option selected value="{{$relproduct->id}}">{{$relproduct->title}}</option>
                                                                    @endforeach
                                                                
                                                                @endif

                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>         
                            </div>



                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                        <select name ="status" id="status" class="form-control">	
                                                 <option {{($product->status==0)? 'selected' : ''}} value="1">active</option>
                                                 <option {{($product->status==1)? 'selected' : ''}} value="0">inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 

                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product Featured</h2>
                                        <div class="mb-3">
                                        <select  class="form-control" name ="is_featured" id="is_featured">
                                                 <option value="no">no</option>
                                                 <option value="yes">yes</option>
                                            </select>
											
                                        </div>
                                    </div>
                                </div> 

                            
                                <div class="card">
                                    <div class="card-body">	
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category_id" id="category" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" {{ isset($product) && $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
									    </div>

										
                                        <div class="mb-3">
                                        <label class="mb-1">Select Subcategory</label>
    					             <select name="subcategory_id" id="subcategory_id" class="form-control get_subcategory"></select>
									    </div>

                                    </div>
                                </div> 

                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
										
											<select name="brand" id="brand" class="form-control" >
                                       
                                             @foreach($brand as $v)
											 
                                             <option value = "{{ $v->id }}" >{{$v->name}}</option>
                                             @endforeach
                                                </select>
									    </div>

                                    </div>
                                
							    </div>  

                            </div>
                        </div>
						
					
						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
						
                        </form>
					</div>
			
				</section>
				
			

					
@endsection --}}

{{-- 

@section('customjs')

<script>
// serch related product fild
$('.related_product').select2({
    ajax: {
        url:'{{ route("product.getproducts") }}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
}); 
</script>


 <script>
    
  
$(document).ready(function(){

$('#category').change(function(){
       let cid=$(this).val();
       $.ajax({
           url:'{{ route("product.getSubCat") }}',
           type:'post',
           data:'cid='+cid+
			  '&_token={{csrf_token()}}',
            
           success:function(result){
            console.log(result);
            $('#subcategory').empty();
                $.each(result, function(key, value) {

                var id = value.id;
                var name = value.name;
                $('#subcategory').append('<option value="'+ id +'">'+ name +'</option>');
            });
           }

       });

  });
});
  
</script>


				
@endsection
 --}} 
