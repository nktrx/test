<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeePhotoService
{

    private $path_global = 'photos';


    public function getPhotoPath(){
        return $this->path_global;
    }

    public function uploadPhoto(UploadedFile $photo, Employee $employee, $adminId): void
    {
        $filename = $this->generateFilename($photo);
        if (!Storage::disk('public')->exists($this->path_global))
            Storage::disk('public')->makeDirectory($this->path_global);
        Storage::disk('public')->putFileAs($this->path_global, $photo, $filename);
        $employee->photo()->create([
            'path' => $this->path_global,
            'name' => $filename,
            'admin_created_id' => $adminId,
            'admin_updated_id' => $adminId,
        ]);
    }

    public function generateFilename(UploadedFile $photo): string
    {
        return Str::uuid() . ".{$photo->getClientOriginalExtension()}";
    }
}