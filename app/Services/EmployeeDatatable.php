<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use JeroenNoten\LaravelAdminLte\Components\Tool\Datatable;
use Yajra\DataTables\Facades\DataTables;

class EmployeeDatatable
{
    private $path_global = 'photos';

    private function getQuery(): Builder
    {
        return Employee::query()->with(['position', 'header']);
    }



    public function build()
    {
        return DataTables::of($this->getQuery())
            ->addColumn('photo', function(Employee $obj) {
                $path = Storage::disk('public')->url("{$this->path_global}/{$obj->photo->name}");
                return $path;
            })
            ->editColumn('employment_date', function(Employee $obj) {
                return $obj->employment_date->format("d.m.y");
            })
            ->editColumn('salary', function(Employee $obj) {
                return number_format($obj->salary, 0, '.',',');
            })
            ->addColumn('action', function (Employee $obj){
                return '<a href="'.route('employees.edit', ['id' => $obj->id]).'" class="btn d-inline"><i class="fa fa-pencil-alt"></i></a> '.view('partials.delete', ['url' => route('employees.delete', ['id' => $obj->id]), 'name'=> $obj->name]);
            });
    }
}
