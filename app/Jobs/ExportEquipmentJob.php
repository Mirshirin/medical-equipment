<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Exports\EquipmentExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportEquipmentJob implements ShouldQueue
{
    use Queueable;
    protected $results;

    /**
     * Create a new job instance.
     */
    public function __construct($results)
    {
        $this->results = $results;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::store(new EquipmentExport($this->results), 'exports/equipments.xlsx');

    }
}
