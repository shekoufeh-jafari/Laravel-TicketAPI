<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionConfigurator
{
    use ApiResponse;

    protected $handlers = [
        ValidationException::class => 'handleValidation',
        NotFoundHttpException::class => 'handleNotFoundHttp',
        AuthenticationException::class => 'handleAuthentication'
    ];



    private function handleValidation(ValidationException $exception)
    {
        foreach ($exception->errors() as $key => $value)
            foreach ($value as $message) {
                $errors[] = [
                    'status' => 422,
                    'message' => $message,
                    'source' => $key
                ];
            }

        return $errors;
    }



    private function handleNotFoundHttp(NotFoundHttpException $exception)
    {
        return [
            [
                'status' => 404,
                'message' => 'The resource cannot be found.',
                'source' => '',
            ]
        ];
    }


    private function handleAuthentication(AuthenticationException $exception)
    {
        return [
            [
                'status' => 401,
                'message' => 'Your are Unauthenticated.',
                'source' => '',
            ]
        ];
    }




    public function __invoke(Exceptions $exceptions): void
    {
        $exceptions->shouldRenderJsonWhen(fn(Request $request, Throwable $e) => true);


        // $exceptions->render(function (Throwable $e, Request $request) {
        //     return new JsonResponse([
        //         'status' => false,
        //         'message' => $e->getMessage(),
        //     ], 400);
        // });




        $exceptions->render(function (Throwable $e, Request $request) {

            $className = get_class($e);

            if (array_key_exists($className, $this->handlers)) {

                $method = $this->handlers[$className];
                return $this->error($this->$method($e));
            }



            
            $index = strrpos($className, '\\');
            return $this->error([
                'type' => substr($className, $index + 1),
                'status' => 0,
                'message' => $e->getMessage(),
                'source' => 'line: ' . $e->getLine() . ' : ' . $e->getFile(),
            ]);



            // if ($e instanceof ValidationException) {
            //     return response()->json([
            //         'errors' => $e->errors(),
            //     ], 422);
            // }

        });
    }
}
