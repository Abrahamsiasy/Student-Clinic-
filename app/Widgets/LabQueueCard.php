<?php

namespace App\Widgets;

use App\Models\Encounter;
use Arrilot\Widgets\AbstractWidget;

require_once app_path('Helper/constants.php');



class labQueueCard extends AbstractWidget
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
        // 12 = Test Pending
        // 13 = Test Available
        // 13 = Test Available


        $opdQueue = Encounter::whereIn('status', [STATUS_TEST_PENDING])->get();
        
        $opdQueueToBe = Encounter::whereIn('status', [STATUS_WAITING])->get();
        // dd($opdQueueToBe);



        return view('widgets.lab_queue_card', [
            'config' => $this->config,
            'reloadTimeout' => $this->reloadTimeout,
            'opdQueue' => $opdQueue,
            'opdQueueToBe' => $opdQueueToBe,


        ]);
    }
}
