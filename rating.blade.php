@extends('admin.layouts.app')

@section('content')


<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								{{-- <a href="{{route('product.create')}}" class="btn btn-primary">New Product</a> --}}
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
                                    <button type="button" onclick="window.location.href='{{route("product.Ratingindex")}}'" class="btn btn-default btn-sm">Reset</button>
                                        
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
								<table class="table table-hover text-nowrap" id="ratingList">
									<thead>
										<tr>
									
											<th>id</th>
											<th>productTitle </th>
											<th>username</th>
											<th>email</th>
											<th>comment</th>
											<th>rating</th>
											<th>status</th>
											
                                            @if(!empty($productratings))    
                                        @foreach($productratings as $rating)

                                        <tr>
                                            <td>{{$rating->id}}</td>
                                            <td>{{isset($rating->productTitle) && $rating->productTitle != '' ? $rating->productTitle : ''}}</td>
                                    
                                            <td>{{isset($rating->username) && $rating->username != '' ? $rating->username: '' }}</td>
                                            <td>{{isset($rating->email) && $rating->email!= '' ? $rating->email: '' }}</td>
                                            <td>{{isset($rating->comment) && $rating->comment!= '' ? $rating->comment: ''}}</td>
                                            <td>{{isset($rating->rating) && $rating->rating!= '' ? $rating->rating: ''}}</td>
                                            <td>	<input id="{{$rating->id}}" class="status-btn" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $rating->status ? 'checked' : '' }}></td>
                                            
                                        </tr>
                                        @endforeach()
                                        @endif()
										
										</tr>
									</thead>
									<tbody>
                                 
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                              
								{{$productratings->links('pagination::bootstrap-4')}}
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

	$("#ratingList").on('change', '.status-btn', function() {
		
        var id = $(this).attr('id');
        
		$.ajax({
            type: "POST",
            url: '{{ route("product.ratingStatus") }}',
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




