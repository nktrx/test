@extends('adminlte::page')
@section('css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}" type="text/css" media="screen"/>

@endsection

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Employee</h2>
    </div>
@endsection

@section('content')
    <div  class="card col-6 custom-content">
        <div class="card-header">
            Add employee
        </div>
        <div class="card-body">
            <form method="post" action="{{route('employees.create')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Photo</label>
                    <label for="photo" class="custom-file-upload text-center">Browse</label>
                    <div class="input-group">
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>
                    <small id="photo-meta" class="text-gray">File format jpg,png up to 5MB, the minimum size of 300x300px</small>
                </div>
                <div class="form-group countable">
                    <label for="name">Name</label>
                    <div class="input-group">
                        <input maxlength="256" value="{{ old('name') }}" type="text" id="name" name="name" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    </div>
                    <small id="name-meta" class="text-gray fa-pull-right text-right d-block">0/256</small>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <div class="input-group">
                        <input type="text" id="phone" name="phone" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                    </div>
                    <small id="name-meta" class="text-gray text-right d-block">Required format +380 (XX) XXX XX XX</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="text" id="email" name="email" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('email')}}</span>
                    </div>
                </div>
                <x-adminlte-select name="position" label="Position">
                    <option value="">Choose position</option>
                    @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->name}}</option>
                    @endforeach
                </x-adminlte-select>
                <div class="form-group countable">
                    <label for="salary">Salary, $</label>
                    <div class="input-group">
                        <input type="text" id="salary" name="salary" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('salary')}}</span>
                    </div>
                </div>
                <x-adminlte-select name="header" label="Head">
                    <option value="">Choose Head</option>
                    @foreach($heads as $head)
                        <option value="{{$head->id}}">{{$head->name}}</option>
                    @endforeach
                </x-adminlte-select>
                <div class="form-group countable">
                    <label for="date">Date of employment</label>
                    <div class="input-group">
                        <input type="date" id="date" name="date" class="form-control">
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <button class="btn btn-primary ml-2">Save</button>
                    <a href="{{route('employees.datatables')}}" class="btn btn-secondary" >Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
