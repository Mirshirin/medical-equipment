<?php

namespace App\Jobs;

namespace App\Jobs;

use App\Models\Equipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNewRecord implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        // ذخیره رکورد جدید در دیتابیس
        Equipment::create([
            'title' => $this->data['title'],
            'description' => $this->data['description'],
            'price_inquiry' => $this->data['price_inquiry'],
        ]);
    }
}
