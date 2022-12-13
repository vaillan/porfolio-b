<?php

namespace App\Http\Controllers\github;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\Github;
use App\Http\Controllers\github\GithubController;
use Carbon\Carbon;

class GithubProcessController extends Controller
{
    /**
     * Agrega un usuario a la cola
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function insertGihubUser(Request $request) {
        try {
            $_request = new Request();
            $user = $request->user;
            $user['org_updated_at'] = Carbon::parse($user['org_updated_at'])->format('Y-m-d');
            $user['org_created_at'] = Carbon::parse($user['org_created_at'])->format('Y-m-d');
            $_request->user = $user;
            $githubJob = new Github($_request, 'github-insert-user');
            dispatch($githubJob);
            return response()->json(['msg' => 'Added']);
        }catch (\Exception $e) {
            return response()->json(['msg' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
