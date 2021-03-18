<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Resources\API\V1\UserCollection;
use App\Http\Resources\API\V1\UserResource;
use App\Http\Requests\API\V1\UserStoreRequest;
use App\Http\Requests\API\V1\UserUpdateRequest;
use Hash;

class UserController extends Controller
{
    /**
     * Get All Users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::paginate(5));
    }

    /**
     * Save User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        // Prepare Data
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        if (User::create($data)) {
            $status = Response::HTTP_CREATED;
            $content['message'] =  'User has been saved successfully.';
        } else {
            $status = Response::HTTP_BAD_REQUEST;
            $content['message'] =  'User has not been saved.';
        }

        return response()->json($content, $status);
    }

    /**
     * Get User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));   
    }

    /**
     * Update User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // Prepare Data
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        if ($user->update($data)) {
            $status = Response::HTTP_ACCEPTED;
            $content['message'] =  'User has been updated successfully.';
        } else {
            $status = Response::HTTP_BAD_REQUEST;
            $content['message'] =  'User has not been updated.';
        }  

        return response()->json($content, $status);
    }

    /**
     * Remove User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            $status = Response::HTTP_ACCEPTED;
            $content['message'] =  'User has been deleted successfully.';
        } else {
            $status = Response::HTTP_BAD_REQUEST;
            $content['message'] =  'User has not been deleted.';
        }  

        return response()->json($content, $status);

    }
}
