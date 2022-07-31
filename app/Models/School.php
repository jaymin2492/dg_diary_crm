<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools';

    protected $fillable = [
        'title',
        'school_type_id',
        'school_level_id',
        'country_id',
        'area_id',
        'population',
        'system',
        'online_student_portal',
        'name_of_the_system',
        'contract_till',
        'sales_rep_id',
        'sales_manager_id',
        'telemarketing_rep_id',
        'director_id',
        'onboarding_rep_id',
        'onboarding_manager_id',
        'school_tution',
        'status',
        'folow_up_date',
        'status_id',
        'manager_status_id',
        'closure_month'
    ];
}
