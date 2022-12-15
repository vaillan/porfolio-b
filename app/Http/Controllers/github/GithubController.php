<?php

namespace App\Http\Controllers\github;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\github\Github;
use Illuminate\Support\Facades\DB;
use App\Models\github\GithubGlobe;

class GithubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $GithubUsers = Github::paginate(100);
        return response()->json(['users' => $GithubUsers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $query = DB::transaction(function () use ($request) {
                $createUser = collect($request->user)->all();
                $user = Github::create($createUser);
                return response()->json(['user' => $user]);
            });
            return $query;
        } catch (\Exception $e) {
            return response()->json(['msg' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getLastUser()
    {
        return response()->json(['user' => Github::latest()->first()]);
    }

    public function createGlobeGraphosUsers(Request $request)
    {
        try {
            $query = DB::transaction(function () use ($request) {
                $githubUser = Github::all();
                $totalUsers = round(($githubUser->count() / 2), 0, PHP_ROUND_HALF_UP);
                $chunkGithubUsers = $githubUser->chunk($totalUsers);
                if ($chunkGithubUsers->count() == 2) {
                    if ($chunkGithubUsers[0]->count() > $chunkGithubUsers[1]->count()) {
                        $first = 0;
                        $second = 1;
                        $this->insert($chunkGithubUsers, $first, $second);
                    } else {
                        $first = 1;
                        $second = 0;
                        $this->insert($chunkGithubUsers, $first, $second);
                    }

                }
                return response()->json(['Ok']);
            });
            return $query;
        } catch (\Exception $e) {
            return response()->json(['msg' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function insert($chunkGithubUsers, $first, $second) {
        $chunkGithubUsers[$first]->each(function ($user, $key) {
            DB::table('globle_users_graphyc')->insert([
                'order' => ($key + 1),
                'startUser' => $user->name,
                'type' => $user->type,
                'startLat' => $user->latitude,
                'startLng' => $user->longitude,
                'status' => true,
                'date' => $user->org_updated_at,
                'created_at' => $user->org_updated_at,
                'updated_at' => $user->org_updated_at
            ]);
        });

        $chunkGithubUsers[$second]->each(function ($user) {
                if(isset($user)) {
                    DB::table('globle_users_graphyc')->where('endUser', null)->where('status', true)->update(
                        [
                            'endUser' => $user->name,
                            'endLat' => $user->latitude,
                            'endLng' => $user->longitude,
                            'updated_at' => $user->updated_at
                        ]
                    );
                }
        });
    }
}
