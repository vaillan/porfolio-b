<?php

namespace App\Models\github;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Github extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'github_users';

    protected $fillable = [
        'avatar_url',
        'bio',
        'blog',
        'company',
        'orig_created_at',
        'email',
        'events_url',
        'followers',
        'followers_url',
        'following',
        'following_url',
        'gists_url',
        'gravatar_id',
        'hireable',
        'html_url',
        'org_id',
        'location',
        'login',
        'name',
        'node_id',
        'organizations_url',
        'public_gists',
        'public_repos',
        'received_events_url',
        'repos_url',
        'site_admin',
        'starred_url',
        'subscriptions_url',
        'twitter_username',
        'type',
        'org_updated_at',
        'url',
        'latitude',
        'longitude',
        'country'
    ];
}
