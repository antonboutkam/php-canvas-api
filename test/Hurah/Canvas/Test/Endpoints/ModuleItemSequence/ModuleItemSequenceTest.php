<?php

namespace Hurah\Canvas\Test\Endpoints\ModuleItemSequence;

use Hurah\Canvas\Endpoints\ModuleItemSequence\ModuleItemSequence;
use PHPUnit\Framework\TestCase;

class ModuleItemSequenceTest extends TestCase
{
    public function testFromCanvasArrayParsesMasteryPath(): void
    {
        $sequence = ModuleItemSequence::fromCanvasArray([
            'items' => [
                [
                    'current' => ['id' => 10, 'title' => 'Current'],
                    'next' => [['id' => 11]],
                    'mastery_path' => [
                        'locked' => false,
                        'assignment_sets' => [
                            ['id' => 'set-a', 'position' => 1],
                        ],
                        'selected_set_id' => 'set-a',
                    ],
                ],
            ],
            'modules' => [
                ['id' => 100],
            ],
        ]);

        static::assertCount(1, $sequence->getItems());
        static::assertCount(1, $sequence->getModules());

        $firstItem = $sequence->getItems()[0];
        static::assertSame(10, $firstItem->getCurrent()['id']);
        static::assertSame('set-a', $firstItem->getMasteryPath()?->getSelectedSetId());
    }

    public function testToCanvasArray(): void
    {
        $sequence = ModuleItemSequence::fromCanvasArray([
            'items' => [
                [
                    'current' => ['id' => 20, 'title' => 'Node'],
                    'mastery_path' => [
                        'selected_set_id' => 7,
                    ],
                ],
            ],
            'modules' => [
                ['id' => 200, 'name' => 'Module A'],
            ],
        ]);

        $canvasArray = $sequence->toCanvasArray();
        static::assertSame(20, $canvasArray['items'][0]['current']['id']);
        static::assertSame(7, $canvasArray['items'][0]['mastery_path']['selected_set_id']);
        static::assertSame(200, $canvasArray['modules'][0]['id']);
    }
}
