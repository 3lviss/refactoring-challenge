<?php

namespace App\Http\Controllers;

use App\Repositories\AccessTokenRepository;
use App\Services\Permissions;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    public function checkPermission(Request $request, $token, $permission)
    {
        try {
            $token = urldecode($token);
            $permission = urldecode($permission);

            $repository = new AccessTokenRepository();
            $tokenData = $repository->findByToken($token);

            if (!$tokenData) {
                return response()->json(['has_permission' => false, 'error' => 'Invalid token']);
            }

            $permissions = Permissions::fromString($tokenData->permissions);
            $hasPermission = $this->validate($permission, $permissions);

            return response()->json(['has_permission' => $hasPermission]);

        } catch (\Exception $e) {
            return response()->json(['has_permission' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    }

    private function validate($requested, $tokenPermissions)
    {
        if ($tokenPermissions instanceof Permissions) {
            $permissionsArray = $tokenPermissions->toArray();

            if (in_array($requested, $permissionsArray) || in_array('all', $permissionsArray)) {
                return true;
            }

            if ($requested == 'all') {
                return count($permissionsArray) > 0;
            }
        }

        return false;
    }
}
