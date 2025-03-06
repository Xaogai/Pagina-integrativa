<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciclo_escolar".
 *
 * @property int $id_ciclo
 * @property string $ciclo
 *
 * @property Alumno[] $alumnos
 * @property CartaAceptacion[] $cartaAceptacions
 * @property CartaPresentacion[] $cartaPresentacions
 * @property CartaTermino[] $cartaTerminos
 * @property HojaDato[] $hojaDatos
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
            [['id_ciclo', 'ciclo'], 'required'],
            [['id_ciclo'], 'integer'],
            [['ciclo'], 'string', 'max' => 100],
            [['id_ciclo'], 'unique'],
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
        return $this->hasMany(Alumno::class, ['id_ciclo' => 'id_ciclo']);
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
        return $this->hasMany(HojaDato::class, ['id_ciclo' => 'id_ciclo']);
    }

}
