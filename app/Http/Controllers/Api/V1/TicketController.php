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

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;


    /**
     * Get All Tickets
     * 
     * @group Managing Tickets
     * @queryparam sort string Data filed(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=title,-createdAt 
     * @queryparam filter[status] Filter by status code: A, C, H, X. No-example
     * @queryparam filter[title] Filter by title. Wildcards are supported. Example: *fix*
     * 
     */

    public function index(TicketFilter $filters)
    {
        // return Ticket::all();
        // return TicketResource::collection(Ticket::all());

        // if ($this->include('author')) {
        //     return TicketResource::collection(Ticket::with('user')->paginate());
        // }

        // return TicketResource::collection(Ticket::paginate());


        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }


/**
     * Create a Tickets
     * 
     * Creates a new ticket. Users can only create tickets for themselves. Managers can create tickets for any user.
     * 
     * @group Managing Tickets
     * 
     */

    public function store(StoreTicketRequest $request)
    {

        //policy
        if ($this->isAble('store', Ticket::class)) {
            return new TicketResource(Ticket::create($request->mappedAttributes()));
        }
        return $this->error('You are not authorized to create that resource.', 401);
    }



    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {

        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($this->include('author')) {
                return new TicketResource($ticket->load('user'));
            }

            return new TicketResource(($ticket));
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        //PATCH
        try {
            $ticket = Ticket::findOrfail($ticket_id);
            //policy
            if ($this->isAble('update', $ticket)) {
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            }

            return $this->error('You are not authorized to update that resource.', 401);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }



    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        // PUT
        try {
            $ticket = Ticket::findOrfail($ticket_id);

            //policy
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
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findOrfail($ticket_id);

            //policy
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
