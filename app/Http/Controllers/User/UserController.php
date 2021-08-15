<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function create(Request $request)
    {
        $input = $request->all();
        $username = $input['username'];
        $password = $input['password'];
        $name = $input['name'];
        $user = User::create($input);
        return response()->json($user,200);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $username = $input['username'];
        $password = $input['password'];
        $user = User::where([
            ['username',$username],
            ['password',$password]
        ])->get()->first();
        if(!$user)
        {
            return response()->json([
                'status'=>'not_ok',
                'data'=>'invalid username or password'
            ],200);
        }
        // generate token
        $response = $this->getTokenFromTMDB();
        $token = $user->createToken("cinemaToken")->plainTextToken;
        return response()->json([
            'status'=>'ok',
            'data'=>[
                 'user'=>$user,
                'token'=>$response->json(),
            ]
        ],200);
    }

    public function getTokenFromTMDB()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlOTk0ZTdmZDc4NjA0MjliMGEwMWFlMjlkMGFiNGUxMSIsInN1YiI6IjYxMDFhM2VkZjY3ODdhMDA3ZTUyOWQxMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.AIYx1Cogvn8rzRYgYNX-kpJlS8j7gepT_t-RNZkNI88',
            'content-type' => 'application/json;charset=utf-8'
        ])->post('https://api.themoviedb.org/4/auth/request_token');

        return $response;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
