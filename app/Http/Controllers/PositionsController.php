<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreatePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Position;
use App\Services\PositionDatatable;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    public function datatables(Request $request, PositionDatatable $datatable)
    {
        if ($request->wantsJson())
            return $datatable->build()->toArray();
        return view('positions.index');
    }

    public function edit(int $id){
        /** @var  Position $position */
        $position = Position::find($id);
        if($position === null)
            return redirect()->back()->withErrors('Position not found','error');
        return view('positions.edit', [
            'id' => $id,
            'name' => $position->name,
            'created_at' => $position->created_at->format('d.m.y'),
            'updated_at' => $position->updated_at->format('d.m.y'),
            'created_id' => $position->adminCreated->id,
            'updated_id' => $position->adminUpdated->id
        ]);
    }

    public function update(UpdatePositionRequest $request)
    {
        $adminId = $request->user()->id;
        /** @var  Position $position */
        $position = Position::find($request->id);
        if($position === null)
            return redirect()->back()->withErrors('Position not found','error');
        $position->update($request->validated());
        return redirect()->route('positions.datatables')->with('notification', 'Successfully edit');
    }

    public function delete(int $id)
    {
        $position = Position::find($id);
        $newPosition = Position::inRandomOrder()->first();
        $position->employees()->update(['position_id' => $newPosition->id]);
        $position->delete();
        return redirect()->route('positions.datatables');
    }

    public function add()
    {
        return view('positions.add');
    }

    public function create(CreatePositionRequest $request)
    {
        /** @var Position $position */
        $adminId = $request->user()->id;
        $position = Position::query()->create([
            'admin_created_id' => $adminId,
            'admin_updated_id' => $adminId,
            'name' => $request->name
        ]);
        return redirect()->route('positions.datatables')->with('notification', 'Successfully created');
    }
}