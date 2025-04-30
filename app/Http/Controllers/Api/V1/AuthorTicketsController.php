<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    protected $policyClass = TicketPolicy::class;


    /**
     * Get All Authors 
     * @authenticated
     * 
     * @group Managing Authors Ticket
     * @queryparam sort string Data filed(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=name,-createdAt 
     * 
     * @queryparam filter[name] Filter by title. Wildcards are supported. Example: *a*
     * 
     */


    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)->filter($filters)->paginate()
        );
    }



    /**
     * Create a Author Ticket
     * @authenticated
     * 
     * Creates a new ticket. Users can only create tickets for themselves. Managers can create tickets for any user.
     * 
     * @group Managing Authors Ticket
     * 
     */
   
    public function store(StoreTicketRequest $request, $author_id)
    {


        //policy
        if ($this->isAble('store', Ticket::class)) {
            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author' => 'user_id'
            ])));
        }
        return $this->error('You are not authorized to create that resource.', 401);
    }

 /**
     * Replace a Author Ticket
     * @authenticated
     * 
     * Replace the specified ticket. 
     * 
     * @group Managing Authors Ticket
     * 
     */

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {
        // PATCH
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            if ($this->isAble('replace', $ticket)) {
                $ticket->update($request->mappedAttributes());
                return new TicketResource($ticket);
            }

            return $this->error('You are not authorized to replace that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }

 /**
     * Update a Author Ticket
     * @authenticated
     * 
     * Update the specified ticket. 
     * 
     * @group Managing Authors Ticket
     * 
     */

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {
        // PUT
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            if ($this->isAble('update', $ticket)) {
                $ticket->update($request->mappedAttributes());
                return new TicketResource($ticket);
            }
            return $this->error('You are not authorized to update that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }




    
      /**
     * Remove a Author Ticket
     * @authenticated
     * 
     * Remove the specified ticket. 
     * 
     * @group Managing Authors Ticket
     * 
     */
    public function destroy($author_id, $ticket_id)
    {
        try {

            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            if ($this->isAble('delete', $ticket)) {
                $ticket->delete();

                return $this->ok('Ticket successfuly deleted');
            }

            return $this->error('You are not authorized to delete that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }
}
