<?php

namespace App\Http\Controllers;

use App\Models\AlertMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AlertMessageController extends Controller
{
    public function alertDestroy(Request $request){
        // Remove the _token key from the request data
        $requestData = $request->except('_token');

        // Get only the values
        $values = array_values($requestData);

        // Now $values contains only the values without the _token value
        // dd($values);
        // Assuming you have a model named YourModel
        AlertMessage::whereIn('id', $values)->delete();
        return Redirect::route('eteeap.dashboard')->with(['status' => 'success', 'message' => 'Successfully clear the notification']);
    }
}
