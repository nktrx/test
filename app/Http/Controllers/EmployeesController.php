<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Photo;
use App\Models\Position;
use App\Services\EmployeeDatatable;
use App\Services\EmployeePhotoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeesController extends Controller
{

    /** @var EmployeePhotoService */
    private $employeePhotoService;

    public function __construct()
    {
        $this->employeePhotoService = new EmployeePhotoService();
    }

    public function datatables(Request $request, EmployeeDatatable $datatable)
    {
        if ($request->wantsJson())
            return $datatable->build()->toArray();
        return view('employees.index');
    }

    public function delete(int $id)
    {
        $employee = Employee::find($id);

        $except = $employee->slave()->get()->pluck('id')->toArray();
        $except = array_merge($except, [$employee->id]);
        $newEmployee = Employee::whereNotIn('id', $except)->inRandomOrder()->first();
        $employee->slave()->update(['header_id' => $newEmployee->id]);

        $employee->photo()->delete();
        $employee->delete();

        return redirect()->route('employees.datatables');
    }

    public function add()
    {
        return view('employees.add',[
            'positions' => Position::all(),
            'heads' => Employee::all(),
            ]);
    }

    public function create(CreateEmployeeRequest $request)
    {
        /** @var Employee $employee */
        $adminId = $request->user()->id;

        $employee = Employee::query()->create([
            'position_id' => $request->position,
            'header_id' => $request->header,
            'admin_created_id' => $adminId,
            'admin_updated_id' => $adminId,
            'name' => $request->name,
            'number' => $request->phone,
            'email' => $request->email,
            'salary' => $request->salary,
            'employment_date' => strtotime($request->date)
        ]);

        $this->uploadPhoto($request->photo, $employee, $adminId);

        return redirect()->route('employees.datatables')->with('notification', 'Successfully created');
    }

    public function edit(int $id){
        /** @var  Employee $employee */
        $employee = Employee::find($id);
        if ($employee === null)
            return redirect()->back()->withErrors('Employee not found','error');
        if ($employee->photo === null)
            $path = '';
        else
            $path = Storage::disk('public')->
            url("{$this->employeePhotoService->getPhotoPath()}/{$employee->photo->name}");
        return view('employees.edit', [
            'id' => $id,
            'photo' => $path,
            'name' => $employee->name,
            'email' => $employee->email,
            'phone' => $employee->number,
            'date' => $employee->employment_date->format('Y-m-d'),
            'salary' => $employee->salary,
            'head' => $employee->header->id,
            'position' => $employee->position->id,
            'created_at' => $employee->created_at->format('d.m.y'),
            'updated_at' => $employee->updated_at->format('d.m.y'),
            'created_id' => $employee->adminCreated->id,
            'updated_id' => $employee->adminUpdated->id,
            'positions' => Position::all(),
            'heads' => Employee::all()
        ]);
    }

    public function update(UpdateEmployeeRequest $request)
    {
        $adminId = $request->user()->id;
        /** @var  Employee $employee */
        $employee = Employee::find($request->id);

        if($employee === null)
            return redirect()->back()->withErrors('Employee not found','error');

        $employee->update($request->validated());

        if($request->photo !== null) {
            $employee->photo()->delete();
            $this->uploadPhoto($request->photo, $employee, $adminId);
        }

        return redirect()->route('employees.datatables')->with('notification', 'Successfully edit');
    }


    private function uploadPhoto(UploadedFile $photo, Employee $employee, $adminId): void
    {
        $this->employeePhotoService->uploadPhoto($photo, $employee, $adminId);
    }
}
