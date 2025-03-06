<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fondo_cbt".
 *
 * @property int $id_fondo
 * @property string $fondo_imagen
 * @property string|null $status
 *
 * @property CartaPresentacion[] $cartaPresentacions
 * @property HojaDatos[] $hojaDatos
 */
class FondoCBT extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_VIGENTE = 'VIGENTE';
    const STATUS_NO_VIGENTE = 'NO VIGENTE';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fondo_cbt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => null],
            [['fondo_imagen'], 'required'],
            [['status'], 'string'],
            [['fondo_imagen'], 'string', 'max' => 100],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_fondo' => 'Id Fondo',
            'fondo_imagen' => 'Fondo Imagen',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[CartaPresentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartaPresentacions()
    {
        return $this->hasMany(CartaPresentacion::class, ['id_formato' => 'id_fondo']);
    }

    /**
     * Gets query for [[HojaDatos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHojaDatos()
    {
        return $this->hasMany(HojaDatos::class, ['id_formato' => 'id_fondo']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_VIGENTE => 'VIGENTE',
            self::STATUS_NO_VIGENTE => 'NO VIGENTE',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusVigente()
    {
        return $this->status === self::STATUS_VIGENTE;
    }

    public function setStatusToVigente()
    {
        $this->status = self::STATUS_VIGENTE;
    }

    /**
     * @return bool
     */
    public function isStatusNoVigente()
    {
        return $this->status === self::STATUS_NO_VIGENTE;
    }

    public function setStatusToNoVigente()
    {
        $this->status = self::STATUS_NO_VIGENTE;
    }
}
