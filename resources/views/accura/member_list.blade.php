@extends('layouts.app')
<title>Accura Memeber List</title> 
@section('content')

<div class="container mt-5">
    <h2 class="card-header">Accura Member List</h2>
    <div class="card-body">
        @session('success')
        <div class="alert alert-success" role="alert" id="alert-success"> {{ $value }} </div>
        @endsession
        <div class="row">
            <div class="col-md-12 d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                <a class="btn btn-success btn-sm" href="{{ route('member.create') }}"> <i class="fa fa-plus"></i> Create New Member</a>
            </div>
        </div>

        <!-- Search and Filter Form -->
        <form action="{{ route('member.list') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- Search by Last name -->
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by Last Name"
                        value="{{ request('search') }}">
                </div>

                <!-- Filter Button -->
                <div class="col-md-2">
                    <div class="d-flex">
                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-primary mr-2" style="margin-right: 10px;">Filter</button>

                        <!-- Refresh Button -->
                        <a href="{{ route('member.list') }}" class="btn btn-secondary">Refresh</a>
                    </div>
                </div>
            </div>
        </form>
    
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date Of Birth</th>
                    <th>DS Division</th>
                    <th>Summery</th>
                    <th width="250px">Actions</th>
                </tr>
            </thead>

            <tbody>
            @if(isset($members) && count($members) > 0)
                @forelse ($members as $member)
                    @php
                        $summery = !empty($member->summary) ? strtoupper($member->summary) : '';
                        $summery_text = !empty($summery) ? $member->last_name.' '.$summery :'' ;
                    @endphp
                    <tr>
                        <td>{{$member->first_name ?? ''}}</td>
                        <td>{{$member->last_name ?? ''}}</td>
                        <td>{{$member->dob ?? '-'}}</td>
                        <td>{{!empty($member->division) ? $member->division->name : ''}}</td>
                        <td>{{$summery_text ?? ''}}</td>
                        <td>
                            <form action="{{ route('member.destroy',$member->id) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="{{ route('member.edit',$member->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm member_delete" data-id="{{$member->id}}"><i class="fa-solid fa-trash"></i> Delete</button>
                                <span class="delete_msg{{$member->id}}"></span>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">There are no data.</td>
                    </tr>
                @endforelse
            @endif
            </tbody>
        </table>
        {!! $members->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div> 

@push('scripts')

<script type="text/javascript">
    $(".member_delete").click(function(e){
        var id = $(this).attr("data-id");

        e.preventDefault();
        var form = $(this).parents("form");

        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
           // form.submit();
           $.ajax({
				url: 'member/delete',
				type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				data: {id: id},
				success: function (data, textStatus, jQxhr) {
                    if(data.success == 1){
                        $('.delete_msg'+id).html('Member Deleted successfully.').css('color','green').css('font-size','12px');
                        setTimeout(function () {
                            $('.delete_msg'+id).hide();
                            location.reload();
                        }, 3000);
                    }else{
                        $('.delete_msg'+id).html('Failed to Delete.').css('color','red').css('font-size','12px');
                        setTimeout(function () {
                            $('.delete_msg'+id).hide();
                        }, 3000);
                    }
				},
				error: function (jqXhr, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});

          }
        });
    });
</script>
@endpush    
@endsection