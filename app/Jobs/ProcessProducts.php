<?php

namespace App\Jobs;

use App\Http\Models\Product\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProcessProducts implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $products;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $products) {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Collection::wrap($this->products)->each(function (Product $product) {
            $product->save();
        });
    }
}
