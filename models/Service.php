<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $duration
 */
class Service extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName(): string
    {
        return '{{service}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['name', 'duration'], 'required'],
            [['name'], 'string'],
            [['duration'], 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Operator name',
            'duration' => 'Service duration in seconds',
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getOperators(): ActiveQuery
    {
        return $this->hasMany(Operator::class, ['id' => 'operator_id'])
            ->viaTable('operator_service', ['service_id' => 'id']);
    }
}
