<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $end_service_at
 */
class Operator extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName(): string
    {
        return '{{operator}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['name'], 'string'],
            [['end_service_at'], 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Operator name',
            'end_service_at' => 'Service end time',
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getServices(): ActiveQuery
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->viaTable('operator_service', ['operator_id' => 'id']);
    }

    /**
     * @return array|ActiveRecord|null
     */
    public static function getFreeOperator(ActiveQuery $operators)
    {
        return $operators->where(['<', 'end_service_at', strtotime('now')])->one();
    }
}
