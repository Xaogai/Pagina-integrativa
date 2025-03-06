<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciclo_escolar".
 *
 * @property int $id_ciclo
 * @property string $ciclo
 *
 * @property Alumnos[] $alumnos
 * @property CartaAceptacion[] $cartaAceptacions
 * @property CartaPresentacion[] $cartaPresentacions
 * @property CartaTermino[] $cartaTerminos
 * @property HojaDatos[] $hojaDatos
 */
class CicloEscolar extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ciclo_escolar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ciclo'], 'required'],
            [['ciclo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ciclo' => 'Id Ciclo',
            'ciclo' => 'Ciclo',
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumnos::class, ['id_ciclo' => 'id_ciclo']);
    }

    /**
     * Gets query for [[CartaAceptacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaAceptacions()
    {
        return $this->hasMany(CartaAceptacion::class, ['id_ciclo' => 'id_ciclo']);
    }

    /**
     * Gets query for [[CartaPresentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaPresentacions()
    {
        return $this->hasMany(CartaPresentacion::class, ['id_ciclo' => 'id_ciclo']);
    }

    /**
     * Gets query for [[CartaTerminos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaTerminos()
    {
        return $this->hasMany(CartaTermino::class, ['id_ciclo' => 'id_ciclo']);
    }

    /**
     * Gets query for [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHojaDatos()
    {
        return $this->hasMany(HojaDatos::class, ['id_ciclo' => 'id_ciclo']);
    }

}
