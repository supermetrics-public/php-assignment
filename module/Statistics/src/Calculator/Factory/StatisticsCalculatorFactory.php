<?php

namespace Statistics\Calculator\Factory;

use Statistics\Calculator\AbstractCalculator;
use Statistics\Calculator\AveragePostLength;
use Statistics\Calculator\CalculatorComposite;
use Statistics\Calculator\CalculatorInterface;
use Statistics\Calculator\MaxPostLength;
use Statistics\Calculator\NoopCalculator;
use Statistics\Calculator\TotalPostsPerWeek;
use Statistics\Calculator\UsersAveragePostsCount;
use Statistics\Dto\ParamsTo;
use Statistics\Enum\StatsEnum;

/**
 * Class StatisticsCalculatorFactory
 *
 * @package Statistics\Calculator
 */
class StatisticsCalculatorFactory
{

    private const CALCULATOR_CLASS_MAP = [
        StatsEnum::AVERAGE_POST_LENGTH          => AveragePostLength::class,
        StatsEnum::MAX_POST_LENGTH              => MaxPostLength::class,
        StatsEnum::TOTAL_POSTS_PER_WEEK         => TotalPostsPerWeek::class,
        StatsEnum::AVERAGE_POST_NUMBER_PER_USER => UsersAveragePostsCount::class,
    ];

    /**
     * @param ParamsTo[] $parameters
     *
     * @return CalculatorInterface
     */
    public static function create(array $parameters): CalculatorInterface
    {
        $calculator = new CalculatorComposite();

        foreach ($parameters as $paramsTo) {
            $statName = $paramsTo->getStatName();
            if (!$paramsTo instanceof ParamsTo
                || !array_key_exists($statName, self::CALCULATOR_CLASS_MAP)
            ) {
                continue;
            }

            $className = self::CALCULATOR_CLASS_MAP[$statName];
            /** @var AbstractCalculator $child */
            $child = new $className();
            $child->setParameters($paramsTo);

            $calculator->addChild($child);
        }

        return $calculator;
    }
}
