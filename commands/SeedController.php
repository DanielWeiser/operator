<?php

namespace app\commands;

use app\models\Operator;
use app\models\Service;
use Faker\Factory;
use Faker\Generator;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    const OPERATOR_COUNT = 10;
    const SERVICE_COUNT = 3;

    private Generator $faker;
    private array $serviceIds = [];

    /**
     * @return int Exit code
     */
    public function actionIndex(): int
    {
        $this->faker = Factory::create();
        $this->createServices();
        $this->createOperators();

        return ExitCode::OK;
    }

    private function createServices(): void
    {
        for ($i = 0; $i < self::SERVICE_COUNT; $i++) {
            $service = new Service();
            $service->setAttribute('name', $this->faker->name);
            $service->setAttribute('duration', rand(10, 100));

            if ($service->save()) {
                $this->serviceIds[] = $service->getAttribute('id');
            }
        }
    }

    private function createOperators(): void
    {
        for ($i = 0; $i < self::OPERATOR_COUNT; $i++) {
            $operator = new Operator();
            $operator->setAttribute('name', $this->faker->name);

            if ($operator->save()) {
                $serviceIds = $this->getRandomServiceIds();

                foreach ($serviceIds as $serviceId) {
                    $service = Service::find()->where(['id' => $serviceId])->one();

                    if ($service) {
                        $operator->link('services', $service);
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    private function getRandomServiceIds(): array
    {
        $serviceCount = rand(1, self::SERVICE_COUNT);
        shuffle($this->serviceIds);

        return array_slice($this->serviceIds, 0, $serviceCount);
    }
}
