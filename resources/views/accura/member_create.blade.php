@extends('layouts.app')
<title>Add Accura Memeber</title> 
@section('content')

<div class="container mt-5">
    <h2 class="card-header add_member">Add Accura Member</h2>
    <form action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <!-- First Name -->
            <div class="col-md-6">
                <label for="first_name" class="form-label"><strong>First Name:</strong></label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" placeholder="First Name" value="{{old('first_name')}}">
                @error('first_name')
                    <div class="form-text text-danger">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <!-- DS Division -->
            <div class="col-md-6">
                <label for="division_id" class="form-label"><strong>DS Division</strong></label>
                <select name="division_id" id="division_id" class="form-control @error('division_id') is-invalid @enderror">
                    <option value="">Select Division</option>
                    @foreach ($division as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('division_id') ?'selected':'' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('division_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <!-- Last Name -->
            <div class="col-md-6">
                <label for="last_name" class="form-label"><strong>Last Name:</strong></label>
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                @error('last_name')
                    <div class="form-text text-danger">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <!-- Date of Birth -->
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{old('dob')}}">
                @error('dob')
                    <div class="form-text text-danger">{{ $message ?? '' }}</div>
                @enderror
            </div>
        </div>

        <!-- Summary -->
        <div class="mb-3">
            <label for="summary" class="form-label"><strong>Summery:</strong></label>
            <textarea class="form-control @error('summary') is-invalid @enderror" style="height:150px;width: 640px;" name="summary" id="summary" placeholder="Summery">{{old('summary')}}</textarea>
            @error('summary')
                <div class="form-text text-danger">{{ $message ?? '' }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-start gap-2">
            <a href="{{ url()->previous() }}" class="back">< Back</a>
            <button type="reset" class="btn btn-warning"><i class="fa-solid fa fa-eraser"></i> Reset</button>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </form>
</div>
@endsection