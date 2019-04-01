<?php

namespace Freshbitsweb\Laratables\Tests;

class OrderingTest extends TestCase
{
    /** @test */
    public function it_orders_the_records_as_expected()
    {
        $user1 = $this->createUsers(
            $count = 1,
            $parameters = [
                'name' => 'Z',
            ]
        )->first();

        $user2 = $this->createUsers(
            $count = 1,
            $parameters = [
                'name' => 'A',
            ]
        )->first();

        $response = $this->json(
            'GET',
            '/datatables-custom-order',
            $this->getDatatablesUrlParameters()
        );

        $response->assertJson([
            'recordsTotal' => 2,
            'data' => [
                [
                    '0' => 2,
                    '1' => $user2->name,
                ],
                [
                    '0' => 1,
                    '1' => $user1->name,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_orders_the_records_with_order_by_raw()
    {
        $user1 = $this->createUsers(
            $count = 1,
            $parameters = [
                'name' => 'Z',
                'email' => 'x@test.com',
            ]
        )->first();

        $user2 = $this->createUsers(
            $count = 1,
            $parameters = [
                'name' => 'A',
                'email' => 'z@test.com',
            ]
        )->first();

        $user3 = $this->createUsers(
            $count = 1,
            $parameters = [
                'name' => 'A',
                'email' => 'a@test.com',
            ]
        )->first();

        $response = $this->json(
            'GET',
            '/datatables-custom-order-raw',
            $this->getDatatablesUrlParameters()
        );

        $response->assertJson([
            'recordsTotal' => 3,
            'data' => [
                [
                    '0' => 1,
                    '1' => $user1->name,
                ],
                [
                    '0' => 3,
                    '1' => $user3->name,
                ],
                [
                    '0' => 2,
                    '1' => $user2->name,
                ],
            ],
        ]);
    }
}
