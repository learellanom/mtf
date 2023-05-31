<?php

namespace App\Observers;

use App\Models\Transaction;
use OwenIt\Auditing\Auditable;
class TransactionsObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        if(!\App::runningInConsole()){
            $transaction->user_id = auth()->user()->id;
          }

         //$model->audit();
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        if(!\App::runningInConsole()){
            $transaction->user_id = auth()->user()->id;
          }

        //$model->audit();
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //$model->audit();
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //$model->audit();
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //$model->audit();
    }
}
