<?php

namespace app\models;

trait GetAllRecordsTrait
{
    /**
     * Obtiene todos los registros de la tabla.
     *
     * @return array
     */
    public static function getAllRecords()
    {
        return self::find()->all();
    }
}