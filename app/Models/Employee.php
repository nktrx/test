<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Employee
 *
 * @property string $name
 * @property string $number
 * @property string $email
 * @property int    $salary
 * @property Carbon    $employment_date
 * @property Carbon    $created_at
 * @property Carbon   $updated_at
 * @property Photo $photo
 * @property int $id
 * @property int $position_id
 * @property int|null $header_id
 * @property int $admin_created_id
 * @property int $admin_updated_id
 * @property-read \App\Models\User $adminCreated
 * @property-read \App\Models\User $adminUpdated
 * @property-read Employee|null $header
 * @property-read \App\Models\Position $position
 * @method static \Database\Factories\EmployeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdminCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdminUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmploymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Employee extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_id', 'header_id', 'admin_created_id', 'admin_updated_id', 'name', 'number', 'email', 'salary', 'employment_date', 'created_at', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string', 'number' => 'string', 'email' => 'string', 'salary' => 'int', 'employment_date' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'employment_date', 'created_at', 'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    public function slave(): HasMany
    {
        return $this->hasMany(Employee::class, 'header_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function photo(): HasOne
    {
        return $this->hasOne(Photo::class);
    }

    public function adminCreated(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function adminUpdated(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
