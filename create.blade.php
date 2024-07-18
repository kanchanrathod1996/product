@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
            <section class="content-header">					
					<div class="container-fluid my-2">	
						<div class="row mb-2">
							<div class="col-sm-6">
                                <h1>{{ isset($product) ? 'Edit' : 'Add' }} Product</h1>

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
                    @include('admin.notifications')

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
                    
                    @if (isset($product))
<form action="{{ route('product.update', $product->id) }}" method="POST" id="categoryForm" name="categoryForm"  enctype="multipart/form-data">
    @method('PUT')
@else
<form action="{{ route('product.store') }}" method="POST" id="categoryForm" name="categoryForm"  enctype="multipart/form-data">
@endif
                  @csrf					
					<div class="row">
						
                            <div class="col-md-8">
								
                                <div class="card mb-3">
                                    <div class="card-body">								
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control" value="{{ isset($product) ? $product->title : '' }}" placeholder="Title">

                                                </div>
                                            </div>

											<div class="col-md-12">
                                                <div class="mb-3">
												     <label for="price">Price</label>
											           <input type="number"   name="price" id="price" value ="{{isset($product) ? $product->price: '' }}" class="form-control" >	
										      </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
												<label for="description">Description</label>
											     <input type="text"   name="description" id="description" value ="{{isset($product) ? $product->description: '' }}"class="form-control" >	
										        </div>
                                            </div> 

											<div class="col-md-12">
                                                <div class="mb-3">
												<label for="shipping_returns">shipping_returns</label>
											     <input type="text"   name="shipping_returns" id="shipping_returns" value ="{{isset($product) ? $product->shipping_returns: '' }}" class="form-control" >	
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
										
											<input type="file"   name="image" id="image" value ="{{isset($product) ? $product->image: '' }}" class="form-control" >	
										
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
                                                    <input type="text"  readonly  name="slug" id="slug" value ="{{isset($product) ? $product->slug: '' }}" class="form-control" placeholder="Slug">	
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">Sku</label>
                                                    <input type="text" name="sku" id="sku" class="form-control"value ="{{isset($product) ? $product->sku: '' }}"  placeholder="sku">	
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
                                                    <input type="number" min="0" name="qty" id="qty" value ="{{isset($product) ? $product->qty: '' }}" class="form-control" placeholder="Qty">	
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
                                        <select  class="form-control" name ="status" id="status">
                                            <option value="">Select</option>
                                            <option {{isset($product) && $product->status==0 ? 'selected':''}}  value="0">active</option>
                                            <option  {{isset($product) && $product->status==1 ? 'selected':''}}  value="1">inactive</option>
                                            </select>
											
                                        </div>
                                    </div>
                                </div> 

                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product Featured</h2>
                                        <div class="mb-3">
                                            <select class="form-control" name="is_featured" id="is_featured">
                                                <option value="">Select</option>
                                                <option value="no" {{ isset($product) && $product->is_featured === 'no' ? 'selected' : '' }}>No</option>
                                                <option value="yes" {{ isset($product) && $product->is_featured === 'yes' ? 'selected' : '' }}>Yes</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div> 

                                <div class="card">
                                    <div class="card-body">	
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
											<label for="category">category</label>
                                                <select name="category_id" id="category" class="form-control" >
                                                    <option value = "" >Select category</option>
                                                        @foreach($category as $list)
                                                        
                                                        <option value = "{{ $list->id }}" >{{$list->name}}</option>
                                                        @endforeach
                                                </select>
									    </div>

										
                                        <div class="mb-3">
                                        <label class="mb-1">Select Subcategory</label>
    					             <select name="subcategory_id" id="subcategory" class="form-control get_subcategory"></select>
									    </div>

                                    </div>
                                </div> 

                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
										
											<select name="brand_id" id="brand" class="form-control" >
                                       
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
							<button type="submit" class="btn btn-primary">Create</button>
							<a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
						
                        </form>
					</div>
			
				</section>
				
			

					
@endsection



@section('customjs')	

<script>

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

