<?php

declare(strict_types=1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

final class UsersAveragePostsCount extends AbstractCalculator
{
    protected const UNITS = 'posts';

    /** @var array<string, int> */
    private array $userPostsCount = [];

    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $userId = $postTo->getAuthorId();
        if (is_null($userId)) {
            return;
        }

        $this->userPostsCount[$userId] = ($this->userPostsCount[$userId] ?? 0) + 1;
    }

    protected function doCalculate(): StatisticsTo
    {
        $statistic = new StatisticsTo();
        $count = count($this->userPostsCount);
        if ($count === 0) {
            return $statistic->setValue(0);
        }

        return $statistic->setValue(
            floor(array_sum($this->userPostsCount) / $count)
        );
    }
}