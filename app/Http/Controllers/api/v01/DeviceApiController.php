<?php

namespace App\Http\Controllers\api\v01;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\DeviceCode;
use App\Models\Kiosk;
use App\Models\User;

class DeviceApiController extends Controller
{
    public function store(Request $request): Response
    {
        // validate the request
        $request->validate([
            'device_code' => [
                'bail',
                'required',
                'max:6',
                'min:6'
            ],
            'device_code_id' => [
                'bail',
                'required',
                'integer'
            ]
        ]);
        $deviceCodeId = $request->get('device_code_id');

        // check if device exists in DeviceCodes Table
        $modelDeviceCodes = new DeviceCode();
        $modelDevice = new Kiosk();
        if (!DB::table($modelDeviceCodes->getTable())
            ->where('id', '=', $deviceCodeId)
            ->where('device_code', '=', $request->get('device_code'))
            ->exists())
            // device not exists
            return response([], 204);

        // get the device
        $device = DB::table($modelDevice->getTable())
            ->where($modelDeviceCodes->getForeignKey(), '=', $deviceCodeId);

        // check device existence
        if (!$device->exists())
            // device doesn't exists in Device Table
            return response([], 204);

        // check if the device has a token already
        if (DB::table('personal_access_tokens')
            ->where('tokenable_id', '=', $device->value('user_id'))
            ->where('device_id', '=', $device->value('id'))
            ->exists())
            // Token already exists
            return response([], 200);

        // login to user and create new token
        /**
         * @var  User $user
         */
        $user = Auth::loginUsingId($device->value('user_id'));
        $token = $user->createToken(
            $device->value('device_name'),
            ['*'],
            $device->value('id')
        )->plainTextToken;

        return response(
            [
                'token' => $token
            ],
            201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param String $deviceId
     * @return Response
     */
    public function destroy(String $deviceId): Response
    {
        DB::table('devices')->where('device_code_id', '=', $deviceId)->delete();
        return response('destroy ' . $deviceId, 204);
    }

}
