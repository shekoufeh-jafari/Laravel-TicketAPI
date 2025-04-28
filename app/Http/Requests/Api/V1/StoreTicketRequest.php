<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;





class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isTicketsController = $this->routeIs('tickets.store');
        $authorIdAttr = $isTicketsController ? 'data.relationships.author.data.id' : 'author';
        $user = Auth::user();
        $authorRule = 'required|integer|exists:users,id';

        $rules = [
            'data' => 'required|array',
            'data.attributes' => 'required|array',
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,X,H',
        ];

        if ($isTicketsController) {
            $rules['data.Relationship'] = 'required|array';
            $rules['data.Relationship.author'] = 'required|array';
            $rules['data.Relationship.author.data'] = 'required|array';
        }

        $rules[$authorIdAttr] = $authorRule . '|size:' . $user->id;


        if ($user->tokenCan(Abilities::CreateTicket)) {
            $rules[$authorIdAttr] = $authorRule;
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->routeIs('authors.tickets.store')) {
            $this->merge([
                'author' => $this->route('author')
            ]);
        }
    }


    public function bodyParameters()
    {
        $documetation = [
            'data.attributes.title' => [
                'description' => "The ticket's title (method)",
                'example' => 'No-example'
            ],
            'data.attributes.description' => [
                'description' => "The ticket's title description",
                'example' => 'No-example'
            ],
            'data.attributes.status' => [
                'description' => "The ticket's title status",
                'example' => 'No-example'
            ]
        ];
        if($this->routeIs('tickets.store')){
            $documetation['data.relationships.author.data.id'] =[
                'description'=>'The author assigned to the ticket.',
                'example' => 'No-example'
            ];
        }else {
            $documetation['author'] =[
                'description'=>'The author assigned to the ticket.',
                'example' => 'No-example'
            ];
        }
        return $documetation;
    }
}
