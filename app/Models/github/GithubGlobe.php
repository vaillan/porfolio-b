<?php

namespace App\Models\github;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubGlobe extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'globle_users_graphyc';

    protected $fillable = [
        'order',
        'startUse',
        'endUser',
        'type',
        'startLat',
        'startLng',
        'endLat',
        'endLng',
        'status',
        'date',
    ];
}
