<?php
namespace Hurah\Canvas\Test\Endpoints\Assignment;

use Hurah\Canvas\Endpoints\Assignment\Assignment;
use PHPUnit\Framework\TestCase;

class AssignmentTest extends TestCase
{
	public function testToCanvasArray()
	{
		$oAssignment = new Assignment();
		$oAssignment->setName('x');
		$oAssignment->setCourseId(12);
		$oAssignment->setPosition(1);
		$oAssignment->setSubmissionTypes(['none']);
		$oAssignment->setPointsPossible(5);
		$oAssignment->setGradingType('not_graded');
		$oAssignment->setDescription('asdasfdasfd');
		static::assertIsArray($oAssignment->toCanvasArray());
		static::assertIsArray($oAssignment->toArray());
		static::assertNull($oAssignment->getId());
		

	}
}
