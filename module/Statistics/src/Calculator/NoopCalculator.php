<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private $userCount = [];

    /**
     * @var int
    */
    private $postCount = 0;

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->postCount++;
        $key = $postTo->getAuthorName();
        //array to store users and their number of posts
        $this->userCount[$key] = ($this->userCount[$key] ?? 0) + 1;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $stats = new StatisticsTo();
        //caculating average number of posts per user in given month parameter
        $value = $this->postCount > 0
        ? $this->postCount / count($this->userCount)
        : 0;
        $stats->setValue(round($value,2));

        /* 
            //this code will be use to show list of users and number of posts by them in the given month
            foreach ($this->userCount as $splitPeriod => $posts) {
                $child = (new StatisticsTo())
                    ->setName($this->parameters->getStatName())
                    ->setSplitPeriod($splitPeriod)
                    ->setValue($posts)
                    ->setUnits(self::UNITS);

                $stats->addChild($child);
            }
        */

        return $stats;
    }
}
