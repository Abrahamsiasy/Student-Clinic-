<?php

namespace App\Http\Controllers;


use App\Models\Encounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


require_once app_path('Helper/constants.php');


class QueueController extends Controller
{
    //
    public function getOPDQueue()
    {
       
        $opdQueueToBe = Encounter::whereIn('status', [STATUS_CHECKED_IN])->whereDate('created_at', now())->paginate(8);

        //dd( now());
        return view('app.queue.opd')->with('opdQueueToBe', $opdQueueToBe);
    }
    public function getLabQueue()
    {
        return view('app.queue.lab');
    }


    public function TableCOntent()
    {
        $opdQueueToBe = Encounter::whereIn('status', [STATUS_CHECKED_IN])->whereDate('created_at', now())->paginate(8);

        // Render the component and return the HTML
        $htmlContent = View::make('widgets.opd_queue_table', ['opdQueueToBe' => $opdQueueToBe])->render();

        return response()->json(['html' => $htmlContent]);
    }
}
