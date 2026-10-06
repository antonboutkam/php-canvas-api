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

	public function testOriginalLtiResourceLinkIdAllowsStrings()
	{
		$assignment = Assignment::fromCanvasArray([
			'name' => 'Example assignment',
			'course_id' => 42,
			'original_lti_resource_link_id' => 'lti-resource-abc',
		]);

		static::assertSame('lti-resource-abc', $assignment->getOriginalLtiResourceLinkId());
	}

	public function testFromCanvasArrayMapsSpeedGraderUrlWithoutOutput(): void
	{
		$this->expectOutputString('');
		$url = 'https://canvas.example.com/courses/42/gradebook/speed_grader?assignment_id=12';
		$assignment = Assignment::fromCanvasArray([
			'name' => 'Example assignment',
			'course_id' => 42,
			'speed_grader_url' => $url,
		]);

		static::assertSame($url, $assignment->getSpeedGraderUrl());
		static::assertSame($url, $assignment->toArray()['speed_grader_url']);
	}

	public function testSpeedGraderUrlMayBeAbsentOrNull(): void
	{
		$this->expectOutputString('');
		static::assertNull(Assignment::fromCanvasArray([])->getSpeedGraderUrl());
		static::assertNull(Assignment::fromCanvasArray(['speed_grader_url' => null])->getSpeedGraderUrl());

		$assignment = new Assignment();
		static::assertSame($assignment, $assignment->setSpeedGraderUrl('https://canvas.example.com/speed_grader'));
		static::assertSame($assignment, $assignment->setSpeedGraderUrl(null));
		static::assertNull($assignment->getSpeedGraderUrl());
	}

	public function testOriginalLtiResourceLinkIdCastsNumericStringsToInt()
	{
		$assignment = Assignment::fromCanvasArray([
			'name' => 'Example assignment',
			'course_id' => 42,
			'original_lti_resource_link_id' => '12345',
		]);

		static::assertSame(12345, $assignment->getOriginalLtiResourceLinkId());
	}
}
