<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductUpdated implements ShouldQueue
{
    use Queueable;

    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function() {
            $product = Product::find($this->data['id']);

            if( ! $product ) throw new \Exception("product not found", 500);

            $product->title = $this->data['title'];
            $product->image = $this->data['image'];
            $product->save();
        });
    }
}
