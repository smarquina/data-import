<?php

/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

return ['bool'       => ['yes' => 'Yes',
                         'no'  => 'No',],
        'ajax'       => ['unsupported' => 'Unsupported operation',],
        'model'      => ['update' => ['correct' => ':Value successfully updated.',
                                      'error'   => 'An error has occurred while updating the record',],
                         'store'  => ['correct' => ':Value successfully stored.',
                                      'error'   => 'An error has occurred while storing the record',],
                         'find'   => ['error' => 'Record not found',],
                         'delete' => ['correct' => ':Value successfully deleted.',
                                      'error'   => 'An error has occurred while deleting the record',],],
        'file'       => ['upload_ok'    => 'File successfully uploaded.',
                         'upload_error' => 'An error has occurred while uploading the file.',],
        'buttons'    => ['save'   => 'Save',
                         'cancel' => 'Cancel',
                         'back'   => 'Return',
                         'delete' => 'Delete',
                         'close'  => 'Close',
                         'edit'   => 'Edit',
                         'accept' => 'Accept',],
        'attributes' => [
            'id'          => 'ID',
            'name'        => 'Name',
            'description' => 'Descrition',
            'created_at'  => 'Creation date',
            'updated_at'  => 'Last update',
            'lang'        => 'Language',
            'file'        => 'File',
            'choose_file' => 'Upload a file',
            'date_from'   => 'Start date',
            'date_to'     => 'End date',
            'date'        => 'Date',
            'actions'     => 'Actions',
        ],
        'menu'       => [
            "products" => "Products",
            'lang'     => 'Language',
        ],
        'lang'       => [
            'success_update' => "Application language has switched to :value",
            'error_update'   => "Language is not eligible",
        ],
];
