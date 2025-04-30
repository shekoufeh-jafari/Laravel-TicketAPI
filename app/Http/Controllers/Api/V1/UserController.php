<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Policies\V1\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;
   /**
     * Get All Users
     * @authenticated
     * 
     * @group Managing Users
     * @queryparam sort string Data filed(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=name,-createdAt 
     * 
     * @queryparam filter[name] Filter by title. Wildcards are supported. Example: *a*
     * 
     */
    public function index(AuthorFilter $filters)
    {

        return UserResource::collection(
            User::filter($filters)->paginate()
        );
    }

  
    /**
     * Create a User
     * @authenticated
     * 
     * Creates a new user. Managers can create User.
     * 
     * @group Managing Users
     * 
     */
    public function store(StoreUserRequest $request)
    {

        //policy
        if ($this->isAble('store', User::class)) {
            return new UserResource(User::create($request->mappedAttributes()));
        }

        return $this->error('You are not authorized to create that resource.', 401);
    }

  
    /**
     * Show a User
     * @authenticated
     * 
     * Display the specified ticket. 
     * 
     * @group Managing Users
     * 
     */
    public function show(User $user)
    {
        if ($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        }
        return new UserResource(($user));
    }



    
    /**
     * Update a User
     * @authenticated
     * 
     * Update the specified User. 
     * 
     * @group Managing Users
     * 
     */ 
    public function update(UpdateUserRequest $request, $user_id)
    {
        //PATCH
        try {
            $user = User::findOrfail($user_id);

            //policy
            if ($this->isAble('update', $user)) {
                $user->update($request->mappedAttributes());

                return new UserResource($user);
            }

            return $this->error('You are not authorized to update that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }



 /**
     * Replace a User
     * @authenticated
     * 
     * Replace the specified User. 
     * 
     * @group Managing Users
     * 
     */

    public function replace(ReplaceUserRequest $request, $user_id)
    {
        // PUT
        try {
            $user = User::findOrfail($user_id);

            //policy
            if ($this->isAble('replace', $user)) {
                $user->update($request->mappedAttributes());

                return new UserResource($user);
            }
            return $this->error('You are not authorized to replace that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }



 /**
     * Remove a User
     * @authenticated
     * 
     * Remove the specified User. 
     * 
     * @group Managing Users
     * 
     */
    public function destroy($user_id)
    {

        try {
            $user = User::findOrfail($user_id);

            //policy
            if ($this->isAble('delete', $user)) {
                $user->delete();

                return $this->ok('User successfuly deleted');
            }
            return $this->error('You are not authorized to delete that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }
}
