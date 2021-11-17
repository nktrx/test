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
            Employee employee
        </div>
        <div class="card-body">
            <form method="post" action="{{route('employees.update', ['id' => $id])}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Photo</label>
                    <label for="photo" class="custom-file-upload text-center">Browse</label>
                    <img  width="200px" height="200px" src="{{$photo}}" class="placeholder" alt="Employee photo">
                    <div class="input-group">
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>
                    <small id="photo-meta" class="text-gray">File format jpg,png up to 5MB, the minimum size of 300x300px</small>
                </div>
                <div class="form-group countable">
                    <label for="name">Name</label>
                    <div class="input-group">
                        <input maxlength="256" value="{{ old('name') ?? $name }}" type="text" id="name" name="name" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    </div>
                    <small id="name-meta" class="text-gray fa-pull-right text-right d-block">0/256</small>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <div class="input-group">
                        <input value="{{ old('phone') ?? $phone }}" type="text" id="phone" name="phone" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                    </div>
                    <small id="name-meta" class="text-gray text-right d-block">Required format +380 (XX) XXX XX XX</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input value="{{ old('email') ?? $email }}" type="text" id="email" name="email" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('email')}}</span>
                    </div>
                </div>
                <x-adminlte-select name="position" label="Position">
                    <option value="">Choose position</option>
                    @foreach($positions as $pos)
                        <option @if(old('position') ?? $position) selected @endif value="{{$pos->id}}">{{$pos->name}}</option>
                    @endforeach
                </x-adminlte-select>
                <div class="form-group countable">
                    <label for="salary">Salary, $</label>
                    <div class="input-group">
                        <input  value="{{ old('salary') ?? $salary }}" type="text" id="salary" name="salary" class="form-control @if($errors->has('name')) is-invalid @endif">
                        <span class="invalid-feedback">{{$errors->first('salary')}}</span>
                    </div>
                </div>
                <x-adminlte-select name="header" label="Head" class="select2-hidden-accessible">
                    <option value="">Choose Head</option>
                    @foreach($heads as $head_it)
                        <option @if(old('head') ?? $head) selected @endif value="{{$head_it->id}}">{{$head_it->name}}</option>
                    @endforeach
                </x-adminlte-select>
                <div class="form-group countable">
                    <label for="date">Date of employment</label>
                    <div class="input-group">
                        <input value="{{ old('date') ?? $date }}" type="date" id="date" name="date" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Created at: {{$created_at}}
                    </div>
                    <div class="col">
                        Admin created ID: {{$created_id}}
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        Updated at: {{$updated_at}}
                    </div>
                    <div class="col">
                        Admin updated ID: : {{$updated_id}}
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
{{--                    <button id="{{$id}}" class="btn btn-primary ml-2">Save</button>--}}
                    <button  class="btn btn-primary ml-2">Save</button>
                    <a href="{{route('employees.datatables')}}" class="btn btn-secondary" >Cancel</a>
                </div>
            </form>

        </div>
    </div>
@endsection
