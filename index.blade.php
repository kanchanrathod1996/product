@extends('admin.layouts.app')

@section('content')


<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{route('product.create')}}" class="btn btn-primary">New Product</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        @include('admin.notifications')
						<div class="card">
                        <form action="" method ="get">
							@csrf
							<div class="card-header">
                                <div class="card-title">
                                    <button type="button" onclick="window.location.href='{{route("product.index")}}'" class="btn btn-default btn-sm">Reset</button>
                                        
                                </div>
                                
                                <div class="card-tools">
									<div class="input-group input-group" style="width: 250px;">
										<input  value ="{{Request::get('keyword')}}" type="text"  name="keyword" class="form-control float-right" placeholder="Search">
					
										<div class="input-group-append">
										  <button type="submit" class="btn btn-default">
											<i class="fas fa-search"></i>
										  </button>
										</div>
									  </div>
								</div>

                                </form>
								
							</div>
							<div class="card-body table-responsive p-0">								
								<table class="table table-hover text-nowrap" id="productList">
									<thead>
										<tr>
										<!-- id	title	slug	category_id	subcategory_id	brand_id		price	
										description	shipping_returns	status -->
											<th>title</th>
											<th>image</th>
											<th>slug</th>
											<th>category</th>
											<th>subcategory</th>
											<th>brand</th>
										
											<th>price</th>
											
											<th>description</th>
											<th>shipping_returns</th>
											<th>status</th>
											<th>Action</th>
										
										
										</tr>
									</thead>
									<tbody>
                                 @if($product->isNotEmpty())
                                 @foreach( $product as $item)
										<tr>	
											
											<td>{{$item->title}}</td>
											<td><img src="/images/{{ $item->image }}" width="100px" height="100px"></td>
											<td>{{$item->slug}}</td>
										
											 <!-- {{-- @dd($item->brands); --}} -->
											<td>{{isset($item->categories->name) && $item->categories->name != '' ? $item->categories->name : '' }}</td>
											<td>{{isset($item->subcategories->name) && $item->subcategories->name != '' ? $item->subcategories->name : '' }}</td>
											<td>{{isset($item->brands->name) && $item->brands->name != '' ? $item->brands->name : ''}}</td>
										
											<td>{{isset($item->price) && $item->price != '' ? $item->price : ''}}</td>
											<td>{{isset($item->description) && $item->description != '' ? $item->description : ''}}</td>
											<td>{{isset($item->shipping_returns) && $item->shipping_returns != '' ? $item->shipping_returns : ''}}</td>
											<td>
												<input id="{{$item->id}}" class="status-btn" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
											  
												  </td>
				
											
															
									<td>

							<a class="btn btn-info btn-sm" href="{{ route('product.edit',$item->id) }}">Edit</a>

							<a  class="btn btn-danger btn-sm" href="{{ route('product.delete',$item->id) }}">delete</a>


									</td>
                                          </tr>
                                               
                                          @endforeach()
                                            @endif()

									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                              
								{{$product->links('pagination::bootstrap-4')}}
							</div>
						</div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			
@endsection






@section('customjs')
<script>
  $(function() {

	$("#productList").on('change', '.status-btn', function() {
		
        var id = $(this).attr('id');
        
		$.ajax({
            type: "POST",
            url: '{{ route("product.changeStatus") }}',
            data: {
                id: id,
			    _token:"{!! csrf_token() !!}"
            },
            success: function(resp) {
                if (resp.success) { 
                    console.log('status change successfully.');
                 
                }
           
			},
			error: function(e) {
				alert('Error: ' + e);
            }
        });
    });

  });
</script>
	


@endsection

