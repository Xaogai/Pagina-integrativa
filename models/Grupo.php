<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos".
 *
 * @property int $id_grupo
 * @property string $nombre
 *
 * @property Alumnos[] $alumnos
 */
class Grupo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Id Grupo',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumnos::class, ['id_grupo' => 'id_grupo']);
    }

}
