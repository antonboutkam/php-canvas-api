<?php


use Hurah\Canvas\Endpoints\Assignment\Assignment;
use PHPUnit\Framework\TestCase;

class AssignmentTest extends TestCase
{

    public function testToCanvasArray()
    {
        $oAssignment = new  Hurah\Canvas\Endpoints\Assignment\Assignment();
        $oAssignment->setName('x');
        $oAssignment->setCourseId(12);
        $oAssignment->setPosition(1);
        $oAssignment->setSubmissionTypes(['none']);
        $oAssignment->setPointsPossible(5);
        $oAssignment->setGradingType('not_graded');
        $oAssignment->setDescription('asdasfdasfd');

        $this->assertIsArray($oAssignment->toCanvasArray());



    }
}
