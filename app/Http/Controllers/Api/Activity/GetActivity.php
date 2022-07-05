<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;

class GetActivity extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id = null)
    {

        try {

            if ($id) {
                $data = Activity::with('company', 'vessel')
                    ->withCount('crew')
                    ->where('id', $id)
                    ->firstOrFail();
            } else {
                $data = Activity::with('company', 'vessel')
                    ->withCount('crew')
                    ->get();
            }

            return response()->json([
                'status' => 'Success',
                'result' => $data
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'activity with id ' . $id . ' not found',
            ], 404);
        }
    }
}
