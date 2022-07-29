<?php

namespace App\Jobs;

use App\Mail\ContributorDonationsReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected object $contributor)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $report = [];

        foreach ($this->contributor->lots()->orderBy('contributor_lot.updated_at', 'asc')->get() as $lot) {
            $report[] = [
                'lot' => $lot->name,
                'organization' => $lot->organization->name,
                'total_sent' => $lot->pivot->total_sent
            ];
        }

        Mail::to($this->contributor->user->email)->send(new ContributorDonationsReport($report));
    }
}
