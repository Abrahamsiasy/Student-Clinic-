<?php

namespace App\Widgets;

use App\Models\Encounter;
use Arrilot\Widgets\AbstractWidget;
use App\LabQueueCard;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ClinicUser;
use App\Models\User;


require_once app_path('Helper/constants.php');



class OpdQueueCard extends AbstractWidget
{
    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */

    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 5;

    protected $config = [];
    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */

    public function placeholder()
    {
        return 'Loading...';
    }

    public function run()
    {
        //
        // 2 = In Progress
        // 7 = On Hold
        // 13 = Test Available
        // 19 = Referral Approved


       // $opdQueue = Encounter::whereIn('status', [ STATUS_IN_PROGRESS])->get();

        $opdQueue = Encounter::whereIn('status', [STATUS_IN_PROGRESS])
                    ->whereNull('arrived_at')
                    ->get();
      
                    

        // Assuming $opdQueue is your collection
        $currentPage = request()->input('page', 1); // Get the current page from the request or default to 1
        $perPage = 4; // Number of items per page

        // Slice the collection to get the items for the current page
        $currentPageItems = $opdQueue->slice(($currentPage - 1) * $perPage, $perPage);

        // Create a LengthAwarePaginator instance
        $opdQueuePaginated = new LengthAwarePaginator($currentPageItems, $opdQueue->count(), $perPage);

        //dd($opdQueuePaginated->Doctor->rooms->first()->clinic->id);

        return view('widgets.opd_queue_card', [
            'config' => $this->config,
            'reloadTimeout' => $this->reloadTimeout,
            'opdQueue' => $opdQueuePaginated,
        ]);
    }
}
