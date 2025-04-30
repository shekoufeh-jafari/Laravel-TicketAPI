<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class AuthorsController extends ApiController
{
      /**
     * Get All Authors
     * @authenticated
     * 
     * @group Managing Authors
     * @queryparam sort string Data filed(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=name,-createdAt 
     * 
     * @queryparam filter[name] Filter by title. Wildcards are supported. Example: *a*
     * 
     */
    public function index(AuthorFilter $filters)
    {
  
        return UserResource::collection(
            User::select('users.*')
                ->join('tickets', 'users.id', '=', 'tickets.user_id')
                ->filter($filters)
                ->distinct()
                ->paginate(15)
        );


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

     /**
     * Show a Authors
     * @authenticated
     * 
     * Display the specified Author. 
     * 
     * @group Managing Authors
     * 
     */
    public function show(User $author)
    {
        if($this->include('tickets')){
            return new UserResource($author->load('tickets'));

        }
        return new UserResource(($author));
    }



    
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

   
    // public function destroy(User $user)
    // {
    //     //
    // }
}
