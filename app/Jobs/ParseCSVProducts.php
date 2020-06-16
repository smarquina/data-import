<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseCSVProducts implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const CHUNK_SIZE = 50;

    private $path;

    /**
     * Create a new job instance.
     *
     * @param string $rows
     */
    public function __construct(string $path) {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $data    = file($this->path);
        $headers = str_getcsv(array_shift($data));
        foreach (array_chunk($data, self::CHUNK_SIZE, true) as $index => $rows) {
            $chunkedProducts = array_filter(array_map(function ($row) use ($headers) {
                return ProductsImport::parseRow($row, $headers);
            }, $rows));

//            (new ProductsExport(Collection::wrap($chunkedProducts)))
//                ->store(uniqid("chunked_", true) . "_{$index}.csv",
//                        'temp',
//                        \Maatwebsite\Excel\Excel::CSV);
            ProcessProducts::dispatch($chunkedProducts);
        }
        unlink($this->path);
    }
}
