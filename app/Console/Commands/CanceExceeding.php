<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\ParkReservation;
use App\Models\Park;

class CanceExceeding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:exceeding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->cancelExceeding();
    }

    public function cancelExceeding(){

        $twoDaysAgo = Carbon::now()->subDays(2);
        $now = Carbon::now();

        $exceedLists = ParkReservation::with(['user', 'park'])
            ->whereBetween('end_time', [$twoDaysAgo, $now])
            ->get();

        foreach($exceedLists as $list){
            $park = Park::find($list->park_id);
            $park->is_occupied = 0;
            $park->save();
        }
    }

}
