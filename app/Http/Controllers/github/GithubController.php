<?php

namespace App\Http\Controllers\github;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\github\Github;
use Illuminate\Support\Facades\DB;
use App\Models\github\GithubGlobe;
use App\Models\github\GithubGlobeUsersLocation;
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
                        $this->insert($chunkGithubUsers, 0, 1);
                    } else {
                        $this->insert($chunkGithubUsers, 1, 0);
                    }
                }
                return response()->json(['Ok']);
            });
            return $query;
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function insert($chunkGithubUsers, $first, $second)
    {
        $mA = $chunkGithubUsers[$first];
        $mB = $chunkGithubUsers[$second];
        $mBKey = (($mB->keys())->all())[0];
        $mA->each(function ($user, $key) use ($mB, &$mBKey) {
            $id = DB::table('globle_users_graphyc')->insertGetId([
                'order' => ($key + 1),
                'startUser' => $user->name,
                'type' => $user->type,
                'startLat' => $user->latitude,
                'startLng' => $user->longitude,
                'status' => (($key + 1) % 2) == 0 ? true : false,
                'date' => $user->org_updated_at,
                'created_at' => $user->org_updated_at,
                'updated_at' => $user->org_updated_at
            ]);
            $_user = $mB->all();
            if(isset($_user[$mBKey])) {
                DB::table('globle_users_graphyc')->where('id', $id)->update(
                    [
                        'endUser' => $_user[$mBKey]->name,
                        'endLat' => $_user[$mBKey]->latitude,
                        'endLng' => $_user[$mBKey]->longitude,
                        'updated_at' => $_user[$mBKey]->updated_at
                    ]
                );
                $mBKey = $mBKey + 1;
            }
        });
    }

    public function getGithubGlobeUsers(Request $request)
    {
        return response()->json(['type' => 'usersCollection', 'users' => GithubGlobe::all()]);
    }

    public function createGithuGlobeUsersLocation(Request $request) 
    {
        try {
            $query = DB::transaction(function () {
                $githubUsers = (Github::all())->groupBy('country');
                $githubUsers->each(function ($user, $key) {
                    $_user = ($user->all())[0];
                    $orientation = (($_user->id + 1) % 2)  == 0 ? 'top' : 'right';
                    DB::table('github_location_users')->insert([
                        'orientation' => $orientation,
                        'size' => 1.0,
                        'location' => $_user->location,
                        'country' => $_user->country,
                        'lat' => $_user->latitude,
                        'lng' => $_user->longitude,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d')
                    ]);
                });
                return response()->json(['msg' => 'Ok']);
            });
            return $query;
        }catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getGithubGlobeUsersLocation(Request $request)
    {
        return response()->json(['type' => 'locationCollection', 'locations' => GithubGlobeUsersLocation::all()]);
    }
}
