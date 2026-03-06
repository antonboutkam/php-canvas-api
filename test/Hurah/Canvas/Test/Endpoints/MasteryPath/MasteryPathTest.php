<?php

namespace Hurah\Canvas\Test\Endpoints\MasteryPath;

use Hurah\Canvas\Endpoints\MasteryPath\MasteryPath;
use PHPUnit\Framework\TestCase;

class MasteryPathTest extends TestCase
{
    public function testFromCanvasArray(): void
    {
        $masteryPath = MasteryPath::fromCanvasArray([
            'locked' => false,
            'assignment_sets' => [
                ['id' => 'set-1', 'position' => 1],
            ],
            'selected_set_id' => 'set-1',
            'awaiting_choice' => true,
            'still_processing' => false,
            'modules_url' => '/modules',
            'choose_url' => '/choose',
            'modules_tab_disabled' => false,
        ]);

        static::assertFalse($masteryPath->getLocked());
        static::assertSame('set-1', $masteryPath->getSelectedSetId());
        static::assertTrue($masteryPath->getAwaitingChoice());
        static::assertSame('/choose', $masteryPath->getChooseUrl());
        static::assertCount(1, $masteryPath->getAssignmentSets());
    }

    public function testToCanvasArray(): void
    {
        $masteryPath = new MasteryPath();
        $masteryPath
            ->setLocked(true)
            ->setSelectedSetId(123)
            ->setAwaitingChoice(false)
            ->setModulesUrl('/modules')
            ->setChooseUrl('/choose');

        $canvasArray = $masteryPath->toCanvasArray();

        static::assertTrue($canvasArray['locked']);
        static::assertSame(123, $canvasArray['selected_set_id']);
        static::assertFalse($canvasArray['awaiting_choice']);
        static::assertSame('/choose', $canvasArray['choose_url']);
    }
}
