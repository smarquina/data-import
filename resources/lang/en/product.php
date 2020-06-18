<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

return [
    'list'       => 'Product list',
    'edit'       => 'Edit product',
    'attributes' => [
        'sku'          => 'SKU',
        'category_id'  => 'Category',
        'price'        => 'Price',
        'stock'        => 'Stock',
        'last_sale_at' => 'Last sale date',
        'import_alg'   => 'processing algorithm',
    ],
    'alert'      => [
        'generation_takes_long' => "Attention. This process does not use work queues and can take several minutes to build. \n Do you wish to continue?",
    ],
    'view'       => [
        'generate_random_product' => 'Build and download random list',
        'download_product_list'   => 'Download random products list',
        'le_alg'                  => 'Laravel Excel algorithm',
        'custom_alg'              => 'Work queues algorithm',
    ],
];
