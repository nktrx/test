<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PositionDatatable
{
    private function getQuery(): Builder
    {
        return Position::query();
    }

    public function build()
    {
        return DataTables::of($this->getQuery())
            ->editColumn('updated_at', function(Position $obj) {
                return $obj->updated_at->format("d.m.y");
            })
            ->addColumn('action', function (Position $obj){
                return '<a href="'.route('positions.edit', ['id' => $obj->id]).'" class="btn d-inline"><i class="fa fa-pencil-alt"></i></a> '.view('partials.delete', ['url' => route('positions.delete', ['id' => $obj->id]), 'name'=> $obj->name]);
            });
    }
}