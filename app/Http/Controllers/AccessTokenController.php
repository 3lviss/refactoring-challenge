<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataObjects\AccessTokenData;
use App\Services\TokenPermissionService;
use App\Contracts\AccessTokenRepositoryInterface;
use App\Http\Requests\AccessTokenRequest;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    public function __invoke(
        AccessTokenRequest $request, 
        TokenPermissionService $service, 
        AccessTokenRepositoryInterface $repository
    ) {
        $accessTokenData = $repository->findByToken($request->token);

        abort_if($accessTokenData === null, 404, 'Access token not found');

        $result = $service->hasPermission($accessTokenData->permissions, $request->input('permission'));

        return response()->json([
            'data' => [
                'has_permission' => $result->hasPermission,
                'permission'     => $result->permission,
            ]
        ], 200);
    }
}
