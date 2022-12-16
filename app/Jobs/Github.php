<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\github\GithubController;

class Github implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $action;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $action)
    {
        $this->data = $data;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->action) {
            case 'github-insert-user':
                $githubController = new GithubController();
                $githubController->store($this->data);
                \DB::table('github_users_status')
                    ->where('table', 'github_users')
                    ->update(
                        ['updated_at' => date('Y-m-d'), 'status' => 1]
                    );
                break;
            case 'graphos':
                $githubController = new GithubController();
                $githubController->createGlobeGraphosUsers($this->data);
                break;
            case 'location':
                $githubController = new GithubController();
                $githubController->createGithuGlobeUsersLocation($this->data);
                break;
            default:
                # code...
                break;
        }
    }
}
