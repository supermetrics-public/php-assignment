<?php

declare(strict_types=1);

namespace Statistics\Tests\Calculator;

use PHPUnit\Framework\TestCase;
use SocialPost\Hydrator\FictionalPostHydrator;
use Statistics\Calculator\UsersAveragePostsCount;
use Statistics\Dto\ParamsTo;

final class UsersAveragePostsCountTest extends TestCase
{
    /**
     * @dataProvider usersPost
     * @test
     */
    public function calculate(array $data, float $expected)
    {
        $calculateService = new UsersAveragePostsCount();
        $calculateService->setParameters((new ParamsTo())->setStatName("test"));

        $hydrator = new FictionalPostHydrator();

        $posts = [];
        foreach ($data as $datum) {
            $calculateService->accumulateData($hydrator->hydrate($datum));
        }

        $this->assertEquals($expected, $calculateService->calculate()->getValue());
    }

    public function usersPost(): array
    {
        return [
            'no_posts' => [
                'data' => [],
                'expectedAverage' => 0
            ],
            'positive_case' => [
                'data' => [
                    [
                        "id" => "post1",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-11T06:38:54+00:00"
                    ],
                    [
                        "id" => "post2",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-12T06:38:54+00:00"
                    ],
                    [
                        "id" => "post3",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-13T06:38:54+00:00"
                    ],
                    [
                        "id" => "post4",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-14T06:38:54+00:00"
                    ],
                    [
                        "id" => "post5",
                        "from_name" => "user2",
                        "from_id" => "user_2",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-13T06:38:54+00:00"
                    ],
                    [
                        "id" => "post6",
                        "from_name" => "user2",
                        "from_id" => "user_2",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-14T06:38:54+00:00"
                    ],
                ],
                'expectedAverage' => 3
            ],
            'there is user with null name' => [
                'data' => [
                    [
                        "id" => "post1",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-11T06:38:54+00:00"
                    ],
                    [
                        "id" => "post2",
                        "from_name" => "user1",
                        "from_id" => "user_1",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-12T06:38:54+00:00"
                    ],
                    [
                        "id" => "post3",
                        "from_name" => "user2",
                        "from_id" => "user_2",
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-13T06:38:54+00:00"
                    ],
                    [
                        "id" => "post4",
                        "from_name" => null,
                        "from_id" => null,
                        "message" => "",
                        "type" => "status",
                        "created_time" => "2018-08-14T06:38:54+00:00"
                    ],
                ],
                'expectedAverage' => 1.0
            ]
        ];
    }
}