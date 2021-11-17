<?php

namespace Database\Seeders;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeePhotoService;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TablesSeeder extends Seeder{
    private $faker;
    private $employeePhotoService;

    public function __construct()
    {
        $this->employeePhotoService = new EmployeePhotoService();
        //$this->faker = new Generator();
        $this->faker =  \Faker\Factory::create();;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        User::factory()->create();

//        DB::table('users')->insert([
//            'name' => 'Base User',
//            'email' => 'base@email.com',
//            'email_verified_at' => now(),
//            'password' => Hash::make('rand'),
//            'remember_token' => Str::random(10),
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);

        DB::table('positions')->insert([
            ['name' => 'Manager',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Senior Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Middle Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Junior Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],
        ]);
        Employee::factory(25)->create();
        foreach(Employee::all() as $employee)
        {
            $path = $this->faker->image();
            $photo = new UploadedFile($path, 'name.png');
            $this->employeePhotoService->uploadPhoto($photo,$employee,$employee->admin_created_id);
            $employee->update(['header_id' => Employee::all()->where(
                'position_id', '<=', $employee->getAttribute('position_id')
            )->random()->id]);
            $employee->push();
        }
    }


}
