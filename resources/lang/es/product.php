<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

return [
    'list'       => 'Listado de productos',
    'edit'       => 'Editar producto',
    'attributes' => [
        'sku'            => 'SKU',
        'category_id'    => 'Categoría',
        'price'          => 'Precio',
        'stock'          => 'Restantes',
        'last_sale_at'   => 'Fecha. última venta',
        'import_alg' => 'Algoritmo de procesamiento',
    ],
    'alert'      => [
        'generation_takes_long' => "Atención. Este proceso no usa colas de trabajo y puede demorarse varios minutos en su construcción. \n ¿Desea continuar?",
    ],
    'view'       => [
        'generate_random_product' => 'Generar y descargar listado aleatorio',
        'download_product_list'   => 'Descargar Listado aleatorio de productos',
        'le_alg'                  => 'Algoritmo Laravel Excel',
        'custom_alg'              => 'Algoritmo de colas de trabajo',
    ],
];
