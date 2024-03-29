<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_users';

    protected $fillable = [
        'role_id',
        'user_id'
    ];

    public function role() {
        return $this->hasOne('App\Models\Role', 'role_id', 'id');
    }
}
