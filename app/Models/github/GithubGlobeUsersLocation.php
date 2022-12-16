<?php

namespace App\Models\github;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubGlobeUsersLocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'github_location_users';

    protected $fillable = [
        'orientation',
        'size',
        'location',
        'country',
        'lat',
        'lng',
    ];
}
