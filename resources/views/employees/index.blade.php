@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}" type="text/css" media="screen"/>
@endsection

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Employees</h2>
        <a href="{{route('employees.add')}}" class="btn btn-primary">Add employee</a>
    </div>

@endsection

@section('content')
    @if(session()->has('notification'))
        <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
            {{session('notification')}}
        </x-adminlte-alert>
    @endif
    <div class="card">
        <div class="card-header">
            Employee list
        </div>
        <div class="card-body overlay-wrapper">
            <table id="employees-table" class="table"></table>
        </div>
    </div>

@endsection
