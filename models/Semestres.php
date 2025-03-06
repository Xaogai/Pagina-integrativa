<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semestre".
 *
 * @property int $id_semestre
 * @property string $nombre
 *
 * @property Alumnos[] $alumnos
 * @property CartaAceptacion[] $cartaAceptacions
 * @property CartaPresentacion[] $cartaPresentacions
 * @property CartaTermino[] $cartaTerminos
 * @property HojaDatos[] $hojaDatos
 */
class Semestres extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semestre';
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
            'id_semestre' => 'Id Semestre',
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
        return $this->hasMany(Alumnos::class, ['id_semestreactual' => 'id_semestre']);
    }

    /**
     * Gets query for [[CartaAceptacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaAceptacions()
    {
        return $this->hasMany(CartaAceptacion::class, ['id_semestre' => 'id_semestre']);
    }

    /**
     * Gets query for [[CartaPresentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaPresentacions()
    {
        return $this->hasMany(CartaPresentacion::class, ['id_semestre' => 'id_semestre']);
    }

    /**
     * Gets query for [[CartaTerminos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaTerminos()
    {
        return $this->hasMany(CartaTermino::class, ['id_semestre' => 'id_semestre']);
    }

    /**
     * Gets query for [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHojaDatos()
    {
        return $this->hasMany(HojaDatos::class, ['id_semestre' => 'id_semestre']);
    }

}
