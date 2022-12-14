<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateActivity extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'companyId' => 'required|exists:company,id',
            'vesselId' => 'required|exists:vessel,id',
            'dateDeparture' => 'required|date_format:Y-m-d',
            'dateReturn' => 'required|date_format:Y-m-d',
            'status' => 'required|in:depart,return',
            'amount' => 'required_id:status,==,return|nullable|integer'
        ],);



        if ($validator->fails()) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Failed to validate data',
                'data' => $validator->errors()
            ], 400);
        }

        try {

            $activity = Activity::findOrFail($id);
            $activity->company_id = $request->companyId;
            $activity->vessel_id = $request->vesselId;
            $activity->departure_date = $request->dateDeparture;
            $activity->return_date = $request->dateReturn;
            $activity->status = $request->status;
            $activity->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'Success update activity to database',
                'companyId' => $activity->id
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => 'ERROR',
                'message' =>$err->getMessage(),
            ], 400);
        }
    }
}
