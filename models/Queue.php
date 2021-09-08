<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $service_id
 */
class Queue extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName(): string
    {
        return '{{queue}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['service_id'], 'required'],
            [['service_id'], 'integer'],
            [
                'service_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Service::class,
                'targetAttribute' => ['service_id' => 'id']
            ],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'service_id' => 'Service id',
        ];
    }
}
