<?php

/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

return ['bool'       => ['yes' => 'Si',
                         'no'  => 'No',],
        'ajax'       => ['unsupported' => 'Operación no soportada',],
        'model'      => ['update' => ['correct' => ':Value actualizado correctamente.',
                                      'error'   => 'Se ha producido un error al actualizar el registro',],
                         'store'  => ['correct' => ':Value creado correctamente.',
                                      'error'   => 'Se ha producido un error al crear el registro',],
                         'find'   => ['error' => 'Registro no encontrado',],
                         'delete' => ['correct' => ':Value eliminado correctamente.',
                                      'error'   => 'Se ha producido un error al eliminar el registro',],],
        'file'       => ['upload_ok'    => 'Fichero Subido correctamente.',
                         'upload_error' => 'Ha ocurrido un error al subir el fichero.',],
        'buttons'    => ['save'   => 'Guardar',
                         'cancel' => 'Cancelar',
                         'back'   => 'Volver',
                         'delete' => 'Eliminar',
                         'close'  => 'Cerrar',
                         'edit'   => 'Editar',
                         'accept' => 'Aceptar',],
        'attributes' => [
            'id'          => 'ID',
            'name'        => 'Nombre',
            'description' => 'Descripción',
            'created_at'  => 'Fecha creación',
            'updated_at'  => 'Última actualización',
            'lang'        => 'Idioma',
            'file'        => 'Fichero',
            'choose_file' => 'Subir un fichero',
            'date_from'   => 'Fecha inicio',
            'date_to'     => 'Fecha finalización',
            'date'        => 'Fecha',
            'location'    => 'Población',
            'actions'     => 'Acciones',
        ],
        'menu'       => [
            "products" => "Productos",
        ],
];
