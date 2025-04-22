<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Filters\V1\AuthorFilter;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('tickets', TicketController::class)->except('update');
    
    Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
    
    Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

    
    
    Route::apiResource('authors', AuthorsController::class);

    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except('update');

    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
    
    Route::patch('authors/{author}/tickets{ticket}', [AuthorTicketsController::class, 'update']);
});
