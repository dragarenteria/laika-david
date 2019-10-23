<?php

namespace App\Jobs;

use App\Mail\ColaEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $detalles;
    public function __construct($detalles)
    {
        $this->detalles = $detalles;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $email = new ColaEmail();
       Mail::to($this->detalles['destinatario'])->send($email);

    }
}
