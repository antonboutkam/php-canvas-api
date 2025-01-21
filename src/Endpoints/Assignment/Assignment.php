<?php

namespace Hurah\Canvas\Endpoints\Assignment;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Endpoints\Course\Course;
use Hurah\Canvas\Endpoints\Submission\SubmissionCollection;
use Hurah\Canvas\Util;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;

class Assignment extends CanvasObject
{
    public ?int $id = null;
    public ?int $position = null;
    public string $name;
    public ?string $description = null;
    public ?DateTime $createdAt = null;
    public ?DateTime $updatedAt = null;
    public ?DateTime $dueAt = null;
    public ?DateTime $lockAt = null;
    public ?DateTime $unlockAt = null;
    public bool $hasOverrides = false;
    public ?int $courseId = null;
    public string $htmlUrl = '';
    public string $submissionsDownloadUrl = '';
    public ?int $assignmentGroupId = null;
    public bool $dueDateRequired = false;
    public ?array $allowedExtensions = null;
    public ?int $maxNameLength = null;
    public ?bool $turnitinEnabled = null;
    public ?bool $vericiteEnabled = null;
    public $turnitinSettings = null; // Still unclear about this one
    public ?bool $gradeGroupStudentsIndividually = null;
    public ?bool $graderNamesVisibleToGrader = null;
    public ?bool $graderNamesVisibleToFinalGrader = null;

    public $externalToolTagAttributes = null; // Still unclear about this one
    public ?bool $peerReviews = false;
    public ?bool $automaticPeerReviews = null;
    public ?int $peerReviewCount = null;
    public ?DateTime $peerReviewsAssignAt = null;
    public bool $intraGroupPeerReviews = false;
    public ?int $groupCategoryId = 1;
    public ?int $needsGradingCount = null;
    public ?array $needsGradingCountBySection = null;
    public ?bool $postToSis = null;
    public ?string $integrationId = null;
    public ?array $integrationData = null;
    public ?float $pointsPossible = null;

    /* the types of submissions allowed for this assignment list containing one or
    * more of the following: 'discussion_topic', 'online_quiz', 'on_paper', 'none',
    * 'external_tool', 'online_text_entry', 'online_url', 'online_upload',
     *  'media_recording', 'student_annotation'
    */
    public ?string $submissionTypes = null;

    // https://canvas.instructure.com/doc/api/assignments.html
    public ?string $gradingType = null;
    public $gradingStandardId; // Still unclear about this one
    public ?bool $published = null;
    public ?bool $unpublishable = null;
    public ?bool $onlyVisibleToOverrides = null;
    public ?bool $lockedForUser = null;
    public ?string $lockExplanation = null;

    public ?bool $freezeOnCopy = null;
    public ?bool $frozen = null;


    public ?bool $submission = null;
    public ?bool $useRubricForGrading = false;
    public ?array $rubricSettings = null;
    public ?array $rubric = null;
    public ?array $assignmentVisibility = null;
    public ?bool $overrides = null;
    public ?bool $omitFromFinalGrade = null;
    public ?bool $hideInGradebook = null;
    public ?bool $moderatedGrading = null;
    public ?int $graderCount = null;
    public ?int $finalGraderId = null;
    public ?bool $graderCommentsVisibleToGraders = null;
    public $scoreStatistics = null;
    public ?bool $canSubmit = null;

    public $annotatableAttachmentId = null;
    public ?bool $muted = null;
    public ?int $allowedAttempts = null;

    public ?bool $canDuplicate = null;
    public ?bool $visibleToEveryone = null;

    protected ?self $previous = null;
    protected ?self $next = null;

    public function __construct()
    {

    }

    public function toCanvasArray():array
    {
        $aData =  array_filter($this->toArray());
        unset($aData['course']);
        /*
        if(!empty($aData['submission_types']))
        {
            $aSubmissionTypes = $aData['submission_types'];
            unset($aData['submission_types']);
            foreach($aSubmissionTypes as $index => $sType)
            {
                $aData['submission_types_' . $index] = $sType;
            }
        }
        */
        // print_r($aData);
        return [
            'assignment' => $aData
        ];
    }

    /**
     * @param array $array
     * @return self
     * @throws NullPointerException
     */
    public static function fromCanvasArray(array $array): self
    {

        $instance = new self();

        foreach ($array as $key => $value) {
            $method = 'set' . Util::underscoreToCamelCase($key, true);
            self::_setValue($instance, $key, $method, $value);
        }
        return $instance;
    }

    public function getNext(): ?Assignment
    {
        if ($this->next) {
            return $this->next;
        }
        $bNextMatch = false;
        $oCanvas = new Canvas();
        $aAllCourseAssignments = $oCanvas->getCourse($this->getCourseId())->getAllAssignments();

        foreach ($aAllCourseAssignments as $assignment) {
            if ($bNextMatch) {
                $this->next = $assignment;
                return $this->next;
            }
            if ($this->getId() == $assignment->getId()) {
                $bNextMatch = true;
            }

        }
        return null;
    }



    /**
     * Returns the local id of the course, not related to Canvas
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->courseId;
    }

    /**
     * Sets the local id of the course, not related to Canvas
     * @param int $courseId
     * @return Assignment
     */
    public function setCourseId(int $courseId): Assignment
    {
        $this->courseId = $courseId;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Assignment
     */
    public function setId(int $id): Assignment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubmission()
    {
        return $this->submission;
    }

    /**
     * @param mixed $submission
     * @return Assignment
     */
    public function setSubmission($submission)
    {
        $this->submission = $submission;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedAttempts(): int
    {
        return $this->allowedAttempts;
    }

    /**
     * @param array $allowedAttempts
     * @return Assignment
     */
    public function setAllowedAttempts(int $allowedAttempts): Assignment
    {
        $this->allowedAttempts = $allowedAttempts;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGraderNamesVisibleToGrader(): bool
    {
        return $this->graderNamesVisibleToGrader;
    }

    /**
     * @param bool $graderNamesVisibleToGrader
     * @return Assignment
     */
    public function setGraderNamesVisibleToGrader(bool $graderNamesVisibleToGrader): Assignment
    {
        $this->graderNamesVisibleToGrader = $graderNamesVisibleToGrader;
        return $this;
    }

    public function getGraderNamesVisibleToFinalGrader(): string
    {
        return $this->graderNamesVisibleToFinalGrader;
    }

    public function setGraderNamesVisibleToFinalGrader(bool $graderNamesVisibleToFinalGrader): Assignment
    {
        $this->graderNamesVisibleToFinalGrader = $graderNamesVisibleToFinalGrader;
        return $this;
    }


    /**
     * @return bool
     */
    public function isCanDuplicate(): bool
    {
        return $this->canDuplicate;
    }

    /**
     * @param bool $canDuplicate
     * @return Assignment
     */
    public function setCanDuplicate(bool $canDuplicate): Assignment
    {
        $this->canDuplicate = $canDuplicate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisibleToEveryone(): bool
    {
        return $this->visibleToEveryone;
    }

    /**
     * @param bool $visibleToEveryone
     * @return Assignment
     */
    public function setVisibleToEveryone(bool $visibleToEveryone): Assignment
    {
        $this->visibleToEveryone = $visibleToEveryone;
        return $this;
    }

    /**
     *
     * @return Assignment|null
     */
    public function getPrevious(): ?Assignment
    {
        if ($this->previous) {
            return $this->previous;
        }
        $previous = null;
        $oCanvas = new Canvas();
        $aAllCourseAssignments = $oCanvas->getCourse($this->getCourseId())->getAllAssignments();

        foreach ($aAllCourseAssignments as $assignment) {
            if ($assignment->getId() === $this->getId()) {
                $this->previous = $previous;
                return $this->previous;
            }
            $previous = $assignment;
        }
        return null;
    }

    public function getSubmissions(int $iLimit = 100): SubmissionCollection
    {
        $canvas = new Canvas();
        return $canvas->getSubmissions($this->getCourseId(), $this->getId(), $iLimit);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Assignment
     */
    public function setName(string $name): Assignment
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * @param string $description
     * @return Assignment
     */
    public function setDescription(string $description): Assignment
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
        }
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Assignment
     */
    public function setCreatedAt(DateTime $createdAt): Assignment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        if ($this->updatedAt === null) {
            $this->updatedAt = new DateTime();
        }
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Assignment
     */
    public function setUpdatedAt(DateTime $updatedAt): Assignment
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDueAt(): DateTime
    {
        if ($this->getId() === null) {
            $this->dueAt = new DateTime();
        }
        return $this->dueAt;
    }

    /**
     * @param DateTime $dueAt
     * @return Assignment
     */
    public function setDueAt(DateTime $dueAt): Assignment
    {
        $this->dueAt = $dueAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLockAt(): DateTime
    {
        return $this->lockAt;
    }

    /**
     * @param DateTime $lockAt
     * @return Assignment
     */
    public function setLockAt(DateTime $lockAt): Assignment
    {
        $this->lockAt = $lockAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUnlockAt(): DateTime
    {
        return $this->unlockAt;
    }

    /**
     * @param DateTime $unlockAt
     * @return Assignment
     */
    public function setUnlockAt(DateTime $unlockAt): Assignment
    {
        $this->unlockAt = $unlockAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHasOverrides(): bool
    {
        return $this->hasOverrides;
    }

    /**
     * @param bool $hasOverrides
     * @return Assignment
     */
    public function setHasOverrides(bool $hasOverrides): Assignment
    {
        $this->hasOverrides = $hasOverrides;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtmlUrl(): string
    {
        return $this->htmlUrl;
    }

    /**
     * @param string $htmlUrl
     * @return Assignment
     */
    public function setHtmlUrl(string $htmlUrl): Assignment
    {
        $this->htmlUrl = $htmlUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubmissionsDownloadUrl(): string
    {
        return $this->submissionsDownloadUrl;
    }

    /**
     * @param string $submissionsDownloadUrl
     * @return Assignment
     */
    public function setSubmissionsDownloadUrl(string $submissionsDownloadUrl): Assignment
    {
        $this->submissionsDownloadUrl = $submissionsDownloadUrl;
        return $this;
    }

    /**
     * @return int
     */
    public function getAssignmentGroupId(): ?int
    {
        return $this->assignmentGroupId ?? null;
    }

    /**
     * @param int $assignmentGroupId
     * @return Assignment
     */
    public function setAssignmentGroupId(int $assignmentGroupId): Assignment
    {
        $this->assignmentGroupId = $assignmentGroupId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDueDateRequired(): bool
    {
        return $this->dueDateRequired;
    }

    /**
     * @param bool $dueDateRequired
     * @return Assignment
     */
    public function setDueDateRequired(bool $dueDateRequired): Assignment
    {
        $this->dueDateRequired = $dueDateRequired;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }

    /**
     * @param array $allowedExtensions
     * @return Assignment
     */
    public function setAllowedExtensions(array $allowedExtensions): Assignment
    {
        $this->allowedExtensions = $allowedExtensions;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxNameLength(): int
    {
        return $this->maxNameLength;
    }

    /**
     * @param int $maxNameLength
     * @return Assignment
     */
    public function setMaxNameLength(int $maxNameLength): Assignment
    {
        $this->maxNameLength = $maxNameLength;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTurnitinEnabled(): bool
    {
        return $this->turnitinEnabled;
    }

    /**
     * @param bool $turnitinEnabled
     * @return Assignment
     */
    public function setTurnitinEnabled(bool $turnitinEnabled): Assignment
    {
        $this->turnitinEnabled = $turnitinEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVericiteEnabled(): bool
    {
        return $this->vericiteEnabled;
    }

    /**
     * @param bool $vericiteEnabled
     * @return Assignment
     */
    public function setVericiteEnabled(bool $vericiteEnabled): Assignment
    {
        $this->vericiteEnabled = $vericiteEnabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTurnitinSettings()
    {
        return $this->turnitinSettings;
    }

    /**
     * @param mixed $turnitinSettings
     * @return Assignment
     */
    public function setTurnitinSettings($turnitinSettings)
    {
        $this->turnitinSettings = $turnitinSettings;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGradeGroupStudentsIndividually(): bool
    {
        return $this->gradeGroupStudentsIndividually;
    }

    /**
     * @param bool $gradeGroupStudentsIndividually
     * @return Assignment
     */
    public function setGradeGroupStudentsIndividually(bool $gradeGroupStudentsIndividually): Assignment
    {
        $this->gradeGroupStudentsIndividually = $gradeGroupStudentsIndividually;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalToolTagAttributes()
    {
        return $this->externalToolTagAttributes;
    }

    /**
     * @param mixed $externalToolTagAttributes
     * @return Assignment
     */
    public function setExternalToolTagAttributes($externalToolTagAttributes)
    {
        $this->externalToolTagAttributes = $externalToolTagAttributes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPeerReviews(): bool
    {
        return $this->peerReviews;
    }

    /**
     * @param bool $peerReviews
     * @return Assignment
     */
    public function setPeerReviews(bool $peerReviews): Assignment
    {
        $this->peerReviews = $peerReviews;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutomaticPeerReviews(): bool
    {
        return $this->automaticPeerReviews;
    }

    /**
     * @param bool $automaticPeerReviews
     * @return Assignment
     */
    public function setAutomaticPeerReviews(bool $automaticPeerReviews): Assignment
    {
        $this->automaticPeerReviews = $automaticPeerReviews;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeerReviewCount(): int
    {
        return $this->peerReviewCount;
    }

    /**
     * @param int $peerReviewCount
     * @return Assignment
     */
    public function setPeerReviewCount(int $peerReviewCount): Assignment
    {
        $this->peerReviewCount = $peerReviewCount;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPeerReviewsAssignAt(): DateTime
    {
        return $this->peerReviewsAssignAt;
    }

    /**
     * @param DateTime $peerReviewsAssignAt
     * @return Assignment
     */
    public function setPeerReviewsAssignAt(DateTime $peerReviewsAssignAt): Assignment
    {
        $this->peerReviewsAssignAt = $peerReviewsAssignAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIntraGroupPeerReviews(): bool
    {
        return $this->intraGroupPeerReviews;
    }

    /**
     * @param bool $intraGroupPeerReviews
     * @return Assignment
     */
    public function setIntraGroupPeerReviews(bool $intraGroupPeerReviews): Assignment
    {
        $this->intraGroupPeerReviews = $intraGroupPeerReviews;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupCategoryId(): int
    {
        return $this->groupCategoryId;
    }

    /**
     * @param int $groupCategoryId
     * @return Assignment
     */
    public function setGroupCategoryId(int $groupCategoryId): Assignment
    {
        $this->groupCategoryId = $groupCategoryId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNeedsGradingCount(): int
    {
        return $this->needsGradingCount;
    }

    /**
     * @param int $needsGradingCount
     * @return Assignment
     */
    public function setNeedsGradingCount(int $needsGradingCount): Assignment
    {
        $this->needsGradingCount = $needsGradingCount;
        return $this;
    }

    /**
     * @return array
     */
    public function getNeedsGradingCountBySection(): array
    {
        return $this->needsGradingCountBySection;
    }

    /**
     * @param array $needsGradingCountBySection
     * @return Assignment
     */
    public function setNeedsGradingCountBySection(array $needsGradingCountBySection): Assignment
    {
        $this->needsGradingCountBySection = $needsGradingCountBySection;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Assignment
     */
    public function setPosition(int $position): Assignment
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPostToSis(): bool
    {
        return $this->postToSis;
    }

    /**
     * @param bool $postToSis
     * @return Assignment
     */
    public function setPostToSis(bool $postToSis): Assignment
    {
        $this->postToSis = $postToSis;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntegrationId(): string
    {
        return $this->integrationId;
    }

    /**
     * @param string $integrationId
     * @return Assignment
     */
    public function setIntegrationId(string $integrationId): Assignment
    {
        $this->integrationId = $integrationId;
        return $this;
    }

    /**
     * @return array
     */
    public function getIntegrationData(): array
    {
        return $this->integrationData;
    }

    /**
     * @param array $integrationData
     * @return Assignment
     */
    public function setIntegrationData(array $integrationData): Assignment
    {
        $this->integrationData = $integrationData;
        return $this;
    }

    /**
     * @return float
     */
    public function getPointsPossible(): float
    {
        return $this->pointsPossible;
    }

    /**
     * @param float $pointsPossible
     * @return Assignment
     */
    public function setPointsPossible(float $pointsPossible): Assignment
    {
        $this->pointsPossible = $pointsPossible;
        return $this;
    }

    /**
     * @return array
     */
    public function getSubmissionTypes(): string
    {
        return $this->submissionTypes;
    }

    /**
     * 'discussion_topic', 'online_quiz', 'on_paper', 'none',
     * 'external_tool', 'online_text_entry', 'online_url', 'online_upload',
     *  'media_recording', 'student_annotation'
     * @param array $submissionTypes
     * @return Assignment
     */
    public function setSubmissionTypes(mixed $submissionTypes): Assignment
    {
        if(is_array($submissionTypes))
        {
            $this->submissionTypes = join(',', $submissionTypes);
        }
        else
        {
            $this->submissionTypes = $submissionTypes;
        }

        return $this;
    }


    /**
     * @return string
     */
    public function getGradingType(): string
    {
        return $this->gradingType;
    }

    /**
     * @see https://canvas.instructure.com/doc/api/assignments.html
     * pass_fail, percent, letter_grade, gpa_scale, points, not_graded
     * @param string $gradingType = 'points'
     * @return Assignment
     */
    public function setGradingType(string $gradingType = 'points'): Assignment
    {
        $this->gradingType = $gradingType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGradingStandardId()
    {
        return $this->gradingStandardId;
    }

    /**
     * @param mixed $gradingStandardId
     * @return Assignment
     */
    public function setGradingStandardId($gradingStandardId)
    {
        $this->gradingStandardId = $gradingStandardId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Assignment
     */
    public function setPublished(bool $published): Assignment
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUnpublishable(): bool
    {
        return $this->unpublishable;
    }

    /**
     * @param bool $unpublishable
     * @return Assignment
     */
    public function setUnpublishable(bool $unpublishable): Assignment
    {
        $this->unpublishable = $unpublishable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlyVisibleToOverrides(): bool
    {
        return $this->onlyVisibleToOverrides;
    }

    /**
     * @param bool $onlyVisibleToOverrides
     * @return Assignment
     */
    public function setOnlyVisibleToOverrides(bool $onlyVisibleToOverrides): Assignment
    {
        $this->onlyVisibleToOverrides = $onlyVisibleToOverrides;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLockedForUser(): bool
    {
        return $this->lockedForUser;
    }

    /**
     * @param bool $lockedForUser
     * @return Assignment
     */
    public function setLockedForUser(bool $lockedForUser): Assignment
    {
        $this->lockedForUser = $lockedForUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getLockExplanation(): string
    {
        return $this->lockExplanation;
    }

    /**
     * @param string $lockExplanation
     * @return Assignment
     */
    public function setLockExplanation(string $lockExplanation): Assignment
    {
        $this->lockExplanation = $lockExplanation;
        return $this;
    }



    /**
     * @return bool
     */
    public function isFreezeOnCopy(): bool
    {
        return $this->freezeOnCopy;
    }

    /**
     * @param bool $freezeOnCopy
     * @return Assignment
     */
    public function setFreezeOnCopy(bool $freezeOnCopy): Assignment
    {
        $this->freezeOnCopy = $freezeOnCopy;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFrozen(): bool
    {
        return $this->frozen;
    }

    /**
     * @param bool $frozen
     * @return Assignment
     */
    public function setFrozen(bool $frozen): Assignment
    {
        $this->frozen = $frozen;
        return $this;
    }


    /**
     * @return bool
     */
    public function isUseRubricForGrading(): bool
    {
        return $this->useRubricForGrading;
    }

    /**
     * @param bool $useRubricForGrading
     * @return Assignment
     */
    public function setUseRubricForGrading(bool $useRubricForGrading): Assignment
    {
        $this->useRubricForGrading = $useRubricForGrading;
        return $this;
    }

    /**
     * @return array
     */
    public function getRubricSettings(): array
    {
        return $this->rubricSettings;
    }

    /**
     * @param array $rubricSettings
     * @return Assignment
     */
    public function setRubricSettings(array $rubricSettings): Assignment
    {
        $this->rubricSettings = $rubricSettings;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRubric()
    {
        return $this->rubric;
    }

    /**
     * @param mixed $rubric
     * @return Assignment
     */
    public function setRubric($rubric)
    {
        $this->rubric = $rubric;
        return $this;
    }

    /**
     * @return array
     */
    public function getAssignmentVisibility(): array
    {
        return $this->assignmentVisibility;
    }

    /**
     * @param array $assignmentVisibility
     * @return Assignment
     */
    public function setAssignmentVisibility(array $assignmentVisibility): Assignment
    {
        $this->assignmentVisibility = $assignmentVisibility;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOverrides()
    {
        return $this->overrides;
    }

    /**
     * @param mixed $overrides
     * @return Assignment
     */
    public function setOverrides($overrides)
    {
        $this->overrides = $overrides;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOmitFromFinalGrade(): bool
    {
        return $this->omitFromFinalGrade;
    }

    /**
     * @param bool $omitFromFinalGrade
     * @return Assignment
     */
    public function setOmitFromFinalGrade(bool $omitFromFinalGrade): Assignment
    {
        $this->omitFromFinalGrade = $omitFromFinalGrade;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideInGradebook(): bool
    {
        return $this->hideInGradebook;
    }

    /**
     * @param bool $hideInGradebook
     * @return Assignment
     */
    public function setHideInGradebook(bool $hideInGradebook): Assignment
    {
        $this->hideInGradebook = $hideInGradebook;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModeratedGrading(): bool
    {
        return $this->moderatedGrading;
    }

    /**
     * @param bool $moderatedGrading
     * @return Assignment
     */
    public function setModeratedGrading(bool $moderatedGrading): Assignment
    {
        $this->moderatedGrading = $moderatedGrading;
        return $this;
    }

    /**
     * @return int
     */
    public function getGraderCount(): int
    {
        return $this->graderCount;
    }

    /**
     * @param int $graderCount
     * @return Assignment
     */
    public function setGraderCount(int $graderCount): Assignment
    {
        $this->graderCount = $graderCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getFinalGraderId(): int
    {
        return $this->finalGraderId;
    }

    /**
     * @param int $finalGraderId
     * @return Assignment
     */
    public function setFinalGraderId(int $finalGraderId): Assignment
    {
        $this->finalGraderId = $finalGraderId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGraderCommentsVisibleToGraders(): bool
    {
        return $this->graderCommentsVisibleToGraders;
    }

    /**
     * @param bool $graderCommentsVisibleToGraders
     * @return Assignment
     */
    public function setGraderCommentsVisibleToGraders(bool $graderCommentsVisibleToGraders): Assignment
    {
        $this->graderCommentsVisibleToGraders = $graderCommentsVisibleToGraders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScoreStatistics()
    {
        return $this->scoreStatistics;
    }

    /**
     * @param mixed $scoreStatistics
     * @return Assignment
     */
    public function setScoreStatistics($scoreStatistics)
    {
        $this->scoreStatistics = $scoreStatistics;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanSubmit(): bool
    {
        return $this->canSubmit;
    }

    /**
     * @param bool $canSubmit
     * @return Assignment
     */
    public function setCanSubmit(bool $canSubmit): Assignment
    {
        $this->canSubmit = $canSubmit;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAnnotatableAttachmentId()
    {
        return $this->annotatableAttachmentId;
    }

    /**
     * @param mixed $annotatableAttachmentId
     * @return Assignment
     */
    public function setAnnotatableAttachmentId($annotatableAttachmentId)
    {
        $this->annotatableAttachmentId = $annotatableAttachmentId;
        return $this;
    }


    /**
     * @return bool
     */
    public function isMuted(): bool
    {
        return $this->muted;
    }

    /**
     * @param bool $muted
     * @return Assignment
     */
    public function setMuted(bool $muted): Assignment
    {
        $this->muted = $muted;
        return $this;
    }




}
