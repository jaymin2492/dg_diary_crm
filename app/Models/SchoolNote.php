<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolNote extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_notes';

    protected $fillable = [
        'notes',
        'folow_up_date',
        'status_id',
        'manager_status_id',
        'closure_month',
        'school_id',
        'status'
    ];
}
