<?php

namespace Tests\Unit\Box;

use App\Services\BoxCreateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Box;

class BoxCreateServiceTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function orderがnullの場合、最後尾に追加できる()
    {
        $box = Box::factory()->create([
            'forward_id' => 0
        ]);

        $input = [
            'title' => 'あ',
            'order' => null
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            'id' => $insertBox->id,
            'forward_id' => $box->id
        ];

        $this->assertDatabaseHas('boxes', $expected);
        $this->assertSame($insertBox->order, 2);
    }

    /** @test */
    public function orderが1より小さい場合、最後尾に追加できる()
    {
        $box = Box::factory()->create([
            'forward_id' => 0
        ]);

        $input = [
            'title' => 'あ',
            'order' => -3
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            'id' => $insertBox->id,
            'forward_id' => $box->id
        ];

        $this->assertDatabaseHas('boxes', $expected);
        $this->assertSame($insertBox->order, 2);
    }

    /** @test */
    public function orderが1の場合、先頭に追加でき、降順のカラムを変更できる()
    {
        $box = Box::factory()->create([
            'forward_id' => 0
        ]);

        $input = [
            'title' => 'あ',
            'order' => 1
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            [
                'id' => $insertBox->id,
                'forward_id' => 0
            ],
            [
                'id' => $box->id,
                'forward_id' => $insertBox->id
            ],
        ];

        $this->assertDatabaseHas('boxes', $expected[0]);
        $this->assertDatabaseHas('boxes', $expected[1]);
        $this->assertSame($insertBox->order, 1);
    }

    /** @test */
    public function orderが1より大きく最後尾より小さい場合、指定の番号に追加でき、降順のカラムを変更できる()
    {
        $box = Box::factory()->create([
            'forward_id' => 0
        ]);
        $box2 = Box::factory()->create([
            'forward_id' => $box->id
        ]);

        $input = [
            'title' => 'あ',
            'order' => 2
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            [
                'id' => $box->id,
                'forward_id' => 0
            ],
            [
                'id' => $insertBox->id,
                'forward_id' => $box->id
            ],
            [
                'id' => $box2->id,
                'forward_id' => $insertBox->id
            ],
        ];

        $this->assertDatabaseHas('boxes', $expected[0]);
        $this->assertDatabaseHas('boxes', $expected[1]);
        $this->assertDatabaseHas('boxes', $expected[2]);
        $this->assertSame($insertBox->order, 2);
    }

    /** @test */
    public function orderが最後尾よりも大きい場合、最後尾に追加できる()
    {
        $box = Box::factory()->create([
            'forward_id' => 0
        ]);

        $input = [
            'title' => 'あ',
            'order' => 100
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            'id' => $insertBox->id,
            'forward_id' => $box->id
        ];

        $this->assertDatabaseHas('boxes', $expected);
        $this->assertSame($insertBox->order, 2);
    }

    /** @test */
    public function テーブルが空の状態でも追加できる()
    {
        $input = [
            'title' => 'あ',
            'order' => 100
        ];
        $service = new BoxCreateService();
        $insertBox = $service->main($input);

        $expected = [
            'id' => $insertBox->id,
            'forward_id' => 0
        ];

        $this->assertDatabaseHas('boxes', $expected);
        $this->assertSame($insertBox->order, 1);
    }
}