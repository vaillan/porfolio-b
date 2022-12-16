<?php

namespace App\Http\Controllers\github;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\Github;
use App\Http\Controllers\github\GithubController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class GithubProcessController extends Controller
{
    /**
     * Agrega un usuario a la cola
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function insertGihubUser(Request $request)
    {
        try {
            $_request = new Request();
            $user = $request->user;
            $user['org_updated_at'] = Carbon::parse($user['org_updated_at'])->format('Y-m-d');
            $user['org_created_at'] = Carbon::parse($user['org_created_at'])->format('Y-m-d');
            $_request->user = $user;
            \DB::table('github_users_status')->updateOrInsert(
                ['id' => 1, 'table' => 'github_users'],
                ['created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d'), 'status' => 0]
            );
            $githubJob = new Github($_request, 'github-insert-user');
            dispatch($githubJob);
            return response()->json(['msg' => 'Added']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createGithubGraphos(Request $request)
    {
        try {
            $_request = new Request();
            DB::table('globle_users_graphyc')->truncate();
            DB::table('github_location_users')->truncate();

            $githubJob1 = new Github($_request, 'graphos');
            dispatch($githubJob1);

            $githubJob2 = new Github($_request, 'location');
            dispatch($githubJob2);

            return response()->json(['msg' => 'Process added']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
