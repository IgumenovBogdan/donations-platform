<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Contributor;
use App\Repositories\SubscriptionsRepository;
use App\Services\StripeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RenewContributorSubscription implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected object $subscription)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        StripeService $stripeService,
        SubscriptionsRepository $subscriptionsRepository
    )
    {

        $contributor = Contributor::find($this->subscription->contributor_id);

        DB::beginTransaction();

        try {

            $stripeService->createCharge(customerId: $contributor->customer_id, price: $this->subscription->amount);
            $subscriptionsRepository->updateSubscriptionDate($this->subscription->id);
            $subscriptionsRepository->createSubscriptionHistory($this->subscription->id);

            DB::commit();

            SendRenewSuccessMessage::dispatch($contributor);
        } catch (\Throwable $e) {
            DB::rollBack();
            SendRenewFailMessage::dispatch($contributor);
        }

    }
}
