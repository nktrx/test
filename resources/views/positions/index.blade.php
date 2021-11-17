@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}" type="text/css" media="screen"/>
@endsection

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Positions</h2>
        <a href="{{route('positions.add')}}" class="btn btn-primary">Add position</a>
    </div>

@endsection

@section('content')
    @if(session()->has('notification'))
        <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
            {{session('notification')}}
        </x-adminlte-alert>
    @endif
    <div class="card">
        <div class="card-body overlay-wrapper">
            <table id="position-table" class="table table-bordered table-striped table-hover"></table>
        </div>
    </div>

@endsection
