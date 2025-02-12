<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\Quiz;

use DateTime;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\ImplementationException;

/**
 * Class Quiz
 * Represents a quiz in the Canvas LMS API.
 */
class Quiz extends CanvasObject
{
    /**
     * @var int|null
     */
    private ?int $id = null;
    /**
     * @var string|null
     */
    private ?string $title = null;
    /**
     * @var string|null
     */
    private ?string $htmlUrl = null;
    /**
     * @var string|null
     */
    private ?string $mobileUrl = null;
    /**
     * @var string|null
     */
    private ?string $previewUrl = null;
    /**
     * @var string|null
     */
    private ?string $description = null;
    /**
     * @var string|null
     */
    private ?string $quizType = null;
    /**
     * @var int|null
     */
    private ?int $assignmentGroupId = null;
    /**
     * @var int|null
     */
    private ?int $timeLimit = null;
    /**
     * @var bool|null
     */
    private ?bool $shuffleAnswers = false;
    /**
     * @var string|null
     */
    private ?string $hideResults = null;
    /**
     * @var bool|null
     */
    private ?bool $showCorrectAnswers = true;
    /**
     * @var bool|null
     */
    private ?bool $showCorrectAnswersLastAttempt = false;
    /**
     * @var DateTime|null
     */
    private ?DateTime $showCorrectAnswersAt = null;
    /**
     * @var DateTime|null
     */
    private ?DateTime $hideCorrectAnswersAt = null;
    /**
     * @var bool|null
     */
    private ?bool $oneTimeResults = false;
    /**
     * @var string|null
     */
    private ?string $scoringPolicy = null;
    /**
     * @var int|null
     */
    private ?int $allowedAttempts = 1;
    /**
     * @var bool|null
     */
    private ?bool $oneQuestionAtATime = false;
    /**
     * @var int|null
     */
    private ?int $questionCount = null;
    /**
     * @var int|null
     */
    private ?int $pointsPossible = null;
    /**
     * @var bool|null
     */
    private ?bool $cantGoBack = false;
    /**
     * @var string|null
     */
    private ?string $accessCode = null;
    /**
     * @var string|null
     */
    private ?string $ipFilter = null;
    /**
     * @var DateTime|null
     */
    private ?DateTime $dueAt = null;
    /**
     * @var DateTime|null
     */
    private ?DateTime $lockAt = null;
    /**
     * @var DateTime|null
     */
    private ?DateTime $unlockAt = null;
    /**
     * @var bool|null
     */
    private ?bool $published = false;
    /**
     * @var bool|null
     */
    private ?bool $unpublishable = true;
    /**
     * @var bool|null
     */
    private ?bool $lockedForUser = false;
    /**
     * @var string|null
     */
    private ?string $lockInfo = null;
    /**
     * @var string|null
     */
    private ?string $lockExplanation = null;
    /**
     * @var string|null
     */
    private ?string $speedgraderUrl = null;
    /**
     * @var string|null
     */
    private ?string $quizExtensionsUrl = null;
    /**
     * @var array|null
     */
    private ?array $permissions = null;
    /**
     * @var array|null
     */
    private ?array $allDates = null;
    /**
     * @var int|null
     */
    private ?int $versionNumber = null;
    /**
     * @var array|null
     */
    private ?array $questionTypes = null;
    /**
     * @var bool|null
     */
    private ?bool $anonymousSubmissions = false;

    /**
     * Create a Quiz object from a Canvas API array.
     *
     * @param array $canvasArray The Canvas API response array.
     * @return self The populated Quiz object.
     */
    public static function fromCanvasArray(array $canvasArray): self
    {
        $quiz = new self();

        $quiz->id = $canvasArray['id'] ?? null;
        $quiz->title = $canvasArray['title'] ?? null;
        $quiz->htmlUrl = $canvasArray['html_url'] ?? null;
        $quiz->mobileUrl = $canvasArray['mobile_url'] ?? null;
        $quiz->previewUrl = $canvasArray['preview_url'] ?? null;
        $quiz->description = $canvasArray['description'] ?? null;
        $quiz->quizType = $canvasArray['quiz_type'] ?? null;
        $quiz->assignmentGroupId = $canvasArray['assignment_group_id'] ?? null;
        $quiz->timeLimit = $canvasArray['time_limit'] ?? null;
        $quiz->shuffleAnswers = $canvasArray['shuffle_answers'] ?? false;
        $quiz->hideResults = $canvasArray['hide_results'] ?? null;
        $quiz->showCorrectAnswers = $canvasArray['show_correct_answers'] ?? true;
        $quiz->showCorrectAnswersLastAttempt = $canvasArray['show_correct_answers_last_attempt'] ?? false;
        $quiz->showCorrectAnswersAt = isset($canvasArray['show_correct_answers_at']) ? $quiz->makeDate($canvasArray['show_correct_answers_at']) : null;
        $quiz->hideCorrectAnswersAt = isset($canvasArray['hide_correct_answers_at']) ? $quiz->makeDate($canvasArray['hide_correct_answers_at']) : null;
        $quiz->oneTimeResults = $canvasArray['one_time_results'] ?? false;
        $quiz->scoringPolicy = $canvasArray['scoring_policy'] ?? null;
        $quiz->allowedAttempts = $canvasArray['allowed_attempts'] ?? 1;
        $quiz->oneQuestionAtATime = $canvasArray['one_question_at_a_time'] ?? false;
        $quiz->questionCount = $canvasArray['question_count'] ?? null;
        $quiz->pointsPossible = $canvasArray['points_possible'] ?? null;
        $quiz->cantGoBack = $canvasArray['cant_go_back'] ?? false;
        $quiz->accessCode = $canvasArray['access_code'] ?? null;
        $quiz->ipFilter = $canvasArray['ip_filter'] ?? null;
        $quiz->dueAt = isset($canvasArray['due_at']) ? $quiz->makeDate($canvasArray['due_at']) : null;
        $quiz->lockAt = isset($canvasArray['lock_at']) ? $quiz->makeDate($canvasArray['lock_at']) : null;
        $quiz->unlockAt = isset($canvasArray['unlock_at']) ? $quiz->makeDate($canvasArray['unlock_at']) : null;
        $quiz->published = $canvasArray['published'] ?? false;
        $quiz->unpublishable = $canvasArray['unpublishable'] ?? true;
        $quiz->lockedForUser = $canvasArray['locked_for_user'] ?? false;
        $quiz->lockInfo = $canvasArray['lock_info'] ?? null;
        $quiz->lockExplanation = $canvasArray['lock_explanation'] ?? null;
        $quiz->speedgraderUrl = $canvasArray['speedgrader_url'] ?? null;
        $quiz->quizExtensionsUrl = $canvasArray['quiz_extensions_url'] ?? null;
        $quiz->permissions = $canvasArray['permissions'] ?? null;
        $quiz->allDates = $canvasArray['all_dates'] ?? null;
        $quiz->versionNumber = $canvasArray['version_number'] ?? null;
        $quiz->questionTypes = $canvasArray['question_types'] ?? null;
        $quiz->anonymousSubmissions = $canvasArray['anonymous_submissions'] ?? false;


        return $quiz;
    }

    /**
     * Convert object properties to an array formatted for Canvas API.
     */
    public function toCanvasArray(): array
    {
        $aData = [
            'quiz' => [
                'id' => $this->id,
                'title' => $this->title,
                'html_url' => $this->htmlUrl,
                'mobile_url' => $this->mobileUrl,
                'preview_url' => $this->previewUrl,
                'description' => $this->description,
                'quiz_type' => $this->quizType,
                'assignment_group_id' => $this->assignmentGroupId,
                'time_limit' => $this->timeLimit,
                'shuffle_answers' => $this->shuffleAnswers,
                'due_at' => $this->formatDt($this->dueAt),
                'lock_at' => $this->formatDt($this->lockAt),
                'unlock_at' => $this->formatDt($this->unlockAt),
                'published' => $this->published,
                'permissions' => $this->permissions,
                'version_number' => $this->versionNumber,
                'question_types' => $this->questionTypes,
                'anonymous_submissions' => $this->anonymousSubmissions,
                'hide_results' => $this->hideResults,
                'show_correct_answers' => $this->showCorrectAnswers,
                'show_correct_answers_last_attempt' => $this->showCorrectAnswersLastAttempt,
                'show_correct_answers_at' => $this->showCorrectAnswersAt,
                'hide_correct_answers_at' => $this->hideCorrectAnswersAt,
                'one_time_results' => $this->oneTimeResults,
                'scoring_policy' => $this->scoringPolicy,
                'allowed_attempts' => $this->allowedAttempts,
                'one_question_at_a_time' => $this->oneQuestionAtATime,
                'question_count' => $this->questionCount,
                'points_possible' => $this->pointsPossible,
                'cant_go_back' => $this->cantGoBack,
                'access_code' => $this->accessCode,
                'ip_filter' => $this->ipFilter,
                'unpublishable' => $this->unpublishable,
                'locked_for_user' => $this->lockedForUser,
                'lock_info' => $this->lockInfo,
                'lock_explanation' => $this->lockExplanation,
                'speedgrader_url' => $this->speedgraderUrl,
                'quiz_extensions_url' => $this->quizExtensionsUrl,
                'all_dates' => $this->allDates

            ]
        ];
        return array_filter($aData);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHtmlUrl(): ?string
    {
        return $this->htmlUrl;
    }

    /**
     * @param string|null $htmlUrl
     * @return $this
     */
    public function setHtmlUrl(?string $htmlUrl): self
    {
        $this->htmlUrl = $htmlUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobileUrl(): ?string
    {
        return $this->mobileUrl;
    }

    /**
     * @param string|null $mobileUrl
     * @return $this
     */
    public function setMobileUrl(?string $mobileUrl): self
    {
        $this->mobileUrl = $mobileUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    /**
     * @param string|null $previewUrl
     * @return $this
     */
    public function setPreviewUrl(?string $previewUrl): self
    {
        $this->previewUrl = $previewUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuizType(): ?string
    {
        return $this->quizType;
    }

    /**
     * @param string|null $quizType [practice_quiz, assignment, graded_survey, survey]
     * @return $this
     */
    public function setQuizType(?string $quizType): self
    {
        if ($quizType && !in_array($quizType, self::getValidQuizTypes())) {
            $this->quizType = $quizType;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    private static function getValidQuizTypes(): array
    {
        return ['practice_quiz', 'assignment', 'graded_survey', 'survey'];
    }

    /**
     * @return int|null
     */
    public function getAssignmentGroupId(): ?int
    {
        return $this->assignmentGroupId;
    }

    /**
     * @param int|null $assignmentGroupId
     * @return $this
     */
    public function setAssignmentGroupId(?int $assignmentGroupId): self
    {
        $this->assignmentGroupId = $assignmentGroupId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTimeLimit(): ?int
    {
        return $this->timeLimit;
    }

    /**
     * @param int|null $timeLimit
     * @return $this
     */
    public function setTimeLimit(?int $timeLimit): self
    {
        $this->timeLimit = $timeLimit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShuffleAnswers(): ?bool
    {
        return $this->shuffleAnswers;
    }

    /**
     * @param bool|null $shuffleAnswers
     * @return $this
     */
    public function setShuffleAnswers(?bool $shuffleAnswers): self
    {
        $this->shuffleAnswers = $shuffleAnswers;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDueAt(): ?DateTime
    {
        return $this->dueAt;
    }

    /**
     * @param string|null $dateTime
     * @return $this
     */
    public function setDueAt(?string $dateTime): self
    {
        $this->dueAt = $this->makeDate($dateTime);
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getLockAt(): ?DateTime
    {
        return $this->lockAt;
    }

    /**
     * @param string|null $dateTime
     * @return $this
     */
    public function setLockAt(?string $dateTime): self
    {
        $this->lockAt = $this->makeDate($dateTime);
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUnlockAt(): ?DateTime
    {
        return $this->unlockAt;
    }

    /**
     * @param string|null $dateTime
     * @return $this
     */
    public function setUnlockAt(?string $dateTime): self
    {
        $this->unlockAt = $this->makeDate($dateTime);
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPublished(): ?bool
    {
        return $this->published;
    }

    /**
     * @param bool|null $published
     * @return $this
     */
    public function setPublished(?bool $published): self
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    /**
     * @param array|null $permissions
     * @return $this
     */
    public function setPermissions(?array $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVersionNumber(): ?int
    {
        return $this->versionNumber;
    }

    /**
     * @param int|null $versionNumber
     * @return $this
     */
    public function setVersionNumber(?int $versionNumber): self
    {
        $this->versionNumber = $versionNumber;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getQuestionTypes(): ?array
    {
        return $this->questionTypes;
    }

    /**
     * @param array|null $questionTypes
     * @return $this
     */
    public function setQuestionTypes(?array $questionTypes): self
    {
        $this->questionTypes = $questionTypes;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAnonymousSubmissions(): ?bool
    {
        return $this->anonymousSubmissions;
    }

    /**
     * @param bool|null $anonymousSubmissions
     * @return $this
     */
    public function setAnonymousSubmissions(?bool $anonymousSubmissions): self
    {
        $this->anonymousSubmissions = $anonymousSubmissions;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHideResults(): ?string
    {
        return $this->hideResults;
    }

    public static function getHideResultOptions(): array
    {
        return ['always', 'until_after_last_attempt'];
    }

    /**
     * @param string|null $hideResults [always, until_after_last_attempt]
     * @return $this
     */
    public function setHideResults(?string $hideResults): self
    {
        if ($hideResults && !in_array($hideResults, self::getHideResultOptions())) {
            throw new ImplementationException("No implementation for hide_results $hideResults");
        }
        $this->hideResults = $hideResults;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowCorrectAnswers(): ?bool
    {
        return $this->showCorrectAnswers;
    }

    /**
     * @param bool|null $showCorrectAnswers
     * @return $this
     */
    public function setShowCorrectAnswers(?bool $showCorrectAnswers): self
    {
        $this->showCorrectAnswers = $showCorrectAnswers;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowCorrectAnswersLastAttempt(): ?bool
    {
        return $this->showCorrectAnswersLastAttempt;
    }

    /**
     * @param bool|null $showCorrectAnswersLastAttempt
     * @return $this
     */
    public function setShowCorrectAnswersLastAttempt(?bool $showCorrectAnswersLastAttempt): self
    {
        $this->showCorrectAnswersLastAttempt = $showCorrectAnswersLastAttempt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getShowCorrectAnswersAt(): ?DateTime
    {
        return $this->showCorrectAnswersAt;
    }

    /**
     * @param string|null $dateTime
     * @return $this
     */
    public function setShowCorrectAnswersAt(?string $dateTime): self
    {
        $this->showCorrectAnswersAt = $this->makeDate($dateTime);
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getHideCorrectAnswersAt(): ?DateTime
    {
        return $this->hideCorrectAnswersAt;
    }

    /**
     * @param string|null $dateTime
     * @return $this
     */
    public function setHideCorrectAnswersAt(?string $dateTime): self
    {
        $this->hideCorrectAnswersAt = $this->makeDate($dateTime);
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOneTimeResults(): ?bool
    {
        return $this->oneTimeResults;
    }

    /**
     * @param bool|null $oneTimeResults
     * @return $this
     */
    public function setOneTimeResults(?bool $oneTimeResults): self
    {
        $this->oneTimeResults = $oneTimeResults;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScoringPolicy(): ?string
    {
        return $this->scoringPolicy;
    }

    /**
     * @param string|null $scoringPolicy
     * @return $this
     */
    public function setScoringPolicy(?string $scoringPolicy): self
    {
        $this->scoringPolicy = $scoringPolicy;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAllowedAttempts(): ?int
    {
        return $this->allowedAttempts;
    }

    /**
     * @param int|null $allowedAttempts
     * @return $this
     */
    public function setAllowedAttempts(?int $allowedAttempts): self
    {
        $this->allowedAttempts = $allowedAttempts;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOneQuestionAtATime(): ?bool
    {
        return $this->oneQuestionAtATime;
    }

    /**
     * @param bool|null $oneQuestionAtATime
     * @return $this
     */
    public function setOneQuestionAtATime(?bool $oneQuestionAtATime): self
    {
        $this->oneQuestionAtATime = $oneQuestionAtATime;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuestionCount(): ?int
    {
        return $this->questionCount;
    }

    /**
     * @param int|null $questionCount
     * @return $this
     */
    public function setQuestionCount(?int $questionCount): self
    {
        $this->questionCount = $questionCount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPointsPossible(): ?int
    {
        return $this->pointsPossible;
    }

    /**
     * @param int|null $pointsPossible
     * @return $this
     */
    public function setPointsPossible(?int $pointsPossible): self
    {
        $this->pointsPossible = $pointsPossible;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCantGoBack(): ?bool
    {
        return $this->cantGoBack;
    }

    /**
     * @param bool|null $cantGoBack
     * @return $this
     */
    public function setCantGoBack(?bool $cantGoBack): self
    {
        $this->cantGoBack = $cantGoBack;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getUnpublishable(): ?bool
    {
        return $this->unpublishable;
    }

    /**
     * @param bool|null $unpublishable
     * @return $this
     */
    public function setUnpublishable(?bool $unpublishable): self
    {
        $this->unpublishable = $unpublishable;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLockedForUser(): ?bool
    {
        return $this->lockedForUser;
    }

    /**
     * @param bool|null $lockedForUser
     * @return $this
     */
    public function setLockedForUser(?bool $lockedForUser): self
    {
        $this->lockedForUser = $lockedForUser;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLockInfo(): ?string
    {
        return $this->lockInfo;
    }

    /**
     * @param string|null $lockInfo
     * @return $this
     */
    public function setLockInfo(?string $lockInfo): self
    {
        $this->lockInfo = $lockInfo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLockExplanation(): ?string
    {
        return $this->lockExplanation;
    }

    /**
     * @param string|null $lockExplanation
     * @return $this
     */
    public function setLockExplanation(?string $lockExplanation): self
    {
        $this->lockExplanation = $lockExplanation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpeedgraderUrl(): ?string
    {
        return $this->speedgraderUrl;
    }

    /**
     * @param string|null $speedgraderUrl
     * @return $this
     */
    public function setSpeedgraderUrl(?string $speedgraderUrl): self
    {
        $this->speedgraderUrl = $speedgraderUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuizExtensionsUrl(): ?string
    {
        return $this->quizExtensionsUrl;
    }

    /**
     * @param string|null $quizExtensionsUrl
     * @return $this
     */
    public function setQuizExtensionsUrl(?string $quizExtensionsUrl): self
    {
        $this->quizExtensionsUrl = $quizExtensionsUrl;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAllDates(): ?array
    {
        return $this->allDates;
    }

    /**
     * @param array|null $allDates
     * @return $this
     */
    public function setAllDates(?array $allDates): self
    {
        $this->allDates = $allDates;
        return $this;
    }

}
