<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    use ApiResponse;

    protected $policyClass;

    public function include(string $relationship): bool
    {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }
        $includeValue = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValue);
    }

    public function isAble($ability, $targetModel)
    {
        try {
            Gate::authorize($ability, $targetModel);
            return true;
        } catch (AuthenticationException $ex) {
            return false;
        }
    }
}
