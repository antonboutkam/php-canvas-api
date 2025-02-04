<?php
namespace Hurah\Canvas\Endpoints\Submission;

use DateTime;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Canvas\Endpoints\Course\Course;
use Hurah\Canvas\Util;



class Submission extends CanvasObject {

    public const TYPES = [
        'online_text_entry',
        'online_url',
        'online_upload',
        'media_recording',
        'basic_lti_launch',
        'student_annotation'
    ];
    public int $id;

    public string $canvas_assignment_id;
    public string $course_id;
    public string $assignment_id;
    /**
     * @var string|null
     */
    protected ?string $body = null;

    /**
     * @var string|null
     */
    
    protected ?string $url = null;
    /**
     * @var string|null
     */
    
    protected ?string $grade = null;

    /**
     * @var float|null
     */
    
    protected ?float $score = null;

    /**
     * @var \DateTimeInterface|null
     */
    
    protected ?\DateTimeInterface $submitted_at = null;

    /**
     * @var ?int
     */
    
    protected ?int $user_id = null;

    /**
     * @var string|null
     */
    
    protected ?string $submission_type = null;

    /**
     * @var string|null
     */
    
    protected ?string $workflow_state = null;

    /**
     * @var bool|null
     */
    
    protected ?bool $grade_matches_current_submission = null;

    /**
     * @var \DateTimeInterface|null
     */
    
    protected ?\DateTimeInterface $graded_at = null;

    /**
     * @var int|null
     */
    
    protected ?int $grader_id = null;

    /**
     * @var int|null
     */
    
    protected ?int $attempt = null;

    /**
     * @var \DateTimeInterface|null
     */
    
    protected ?\DateTimeInterface $cached_due_date = null;

    /**
     * @var bool|null
     */
    
    protected ?bool $excused = null;

    /**
     * @var string|null
     */
    
    protected ?string $late_policy_status = null;

    /**
     * @var float|null
     */
    
    protected ?float $points_deducted = null;

    /**
     * @var int|null
     */
    
    protected ?int $grading_period_id = null;

    /**
     * @var int|null
     */
    
    protected ?int $extra_attempts = null;

    /**
     * @var \DateTimeInterface|null
     */
    
    protected ?\DateTimeInterface $posted_at = null;

    /**
     * @var string|null
     */
    
    protected ?string $redo_request = null;

    /**
     * @var int|null
     */
    
    protected ?int $custom_grade_status_id = null;

    /**
     * @var string|null
     */
    
    protected ?string $sticker = null;
    protected ?string $attachments = null;

    /**
     * @var bool|null
     */
    
    protected ?bool $late = null;

    /**
     * @var bool|null
     */
    
    protected ?bool $missing = null;

    /**
     * @var int|null
     */
    
    protected ?int $seconds_late = null;

    /**
     * @var string|null
     */
    
    protected ?string $entered_grade = null;

    /**
     * @var float|null
     */
    
    protected ?float $entered_score = null;

    /**
     * @var string|null
     */
    
    protected ?string $preview_url = null;

    public function toCanvasArray():array
    {
        return ['submission' => array_filter($this->toArray())];
    }

    public function setAttachments(string $sAttachments):self
    {
        $this->attachments = $sAttachments;
        return $this;
    }
    public function getAttachments():array
    {
        return json_decode($this->attachments);
    }

    /**
     * @param array $array
     * @return self
     * @throws NullPointerException
     */
    public static function fromCanvasArray(array $array, Assignment $assignment) : self {

        $instance = new self();
        $instance->setAssignmentId($assignment->getId());
        $instance->setCourseId($assignment->getCourseId());

        foreach ($array as $key => $value) {
            $method = 'set' . Util::underscoreToCamelCase($key, true);
            if(is_array($value))
            {
                // echo $key . '--->'  . $method . ' -----> ' . json_encode($value) . PHP_EOL;
                self::_setValue($instance, $key, $method, $value);
            }
            else
            {
                // echo $key . '--->'  . $method . ' -----> ' . $value . PHP_EOL;
                self::_setValue($instance, $key, $method, $value);
            }

        }
        return $instance;
    }

    /**
     * @return string
     */
    public function getCanvasAssignmentId(): string
    {
        return $this->canvas_assignment_id;
    }

    /**
     * @param string $canvas_assignment_id
     * @return Submission
     */
    public function setCanvasAssignmentId(string $canvas_assignment_id): Submission
    {
        $this->canvas_assignment_id = $canvas_assignment_id;
        return $this;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Submission
     */
    public function setId(int $id): Submission
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return string
     */
    public function getCourseId(): string
    {
        return $this->course_id;
    }

    /**
     * @param string $course_id
     * @return Submission
     */
    public function setCourseId(string $course_id): Submission
    {
        $this->course_id = $course_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAssignmentId(): string
    {
        return $this->assignment_id;
    }

    /**
     * @param string $assignment_id
     * @return Submission
     */
    public function setAssignmentId(string $assignment_id): Submission
    {
        $this->assignment_id = $assignment_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return Submission
     */
    public function setBody(?string $body): Submission
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Submission
     */
    public function setUrl(?string $url): Submission
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrade(): ?string
    {
        return $this->grade;
    }

    /**
     * @param string|null $grade
     * @return Submission
     */
    public function setGrade(?string $grade): Submission
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getScore(): ?float
    {
        return $this->score;
    }

    /**
     * @param float|null $score
     * @return Submission
     */
    public function setScore(?float $score): Submission
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submitted_at;
    }

    /**
     * @param \DateTimeInterface|null $submitted_at
     * @return Submission
     */
    public function setSubmittedAt(?\DateTimeInterface $submitted_at): Submission
    {
        $this->submitted_at = $submitted_at;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return Submission
     */
    public function setUserId(?int $user_id): Submission
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubmissionType(): ?string
    {
        return $this->submission_type;
    }

    /**
     * @param string|null $submission_type valid options are: online_text_entry, online_url, online_upload, media_recording, basic_lti_launch, student_annotation
     * @return Submission
     */
    public function setSubmissionType(?string $submission_type): Submission
    {
        if($submission_type && !in_array($submission_type, self::TYPES))
        {
            throw new InvalidArgumentException('Submission type must be one of ' . join(', ', self::TYPES));
        }
        $this->submission_type = $submission_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorkflowState(): ?string
    {
        return $this->workflow_state;
    }

    /**
     * @param string|null $workflow_state
     * @return Submission
     */
    public function setWorkflowState(?string $workflow_state): Submission
    {
        $this->workflow_state = $workflow_state;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getGradeMatchesCurrentSubmission(): ?bool
    {
        return $this->grade_matches_current_submission;
    }

    /**
     * @param bool|null $grade_matches_current_submission
     * @return Submission
     */
    public function setGradeMatchesCurrentSubmission(?bool $grade_matches_current_submission): Submission
    {
        $this->grade_matches_current_submission = $grade_matches_current_submission;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getGradedAt(): ?\DateTimeInterface
    {
        return $this->graded_at;
    }

    /**
     * @param \DateTimeInterface|null $graded_at
     * @return Submission
     */
    public function setGradedAt(?\DateTimeInterface $graded_at): Submission
    {
        $this->graded_at = $graded_at;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGraderId(): ?int
    {
        return $this->grader_id;
    }

    /**
     * @param int|null $grader_id
     * @return Submission
     */
    public function setGraderId(?int $grader_id): Submission
    {
        $this->grader_id = $grader_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAttempt(): ?int
    {
        return $this->attempt;
    }

    /**
     * @param int|null $attempt
     * @return Submission
     */
    public function setAttempt(?int $attempt): Submission
    {
        $this->attempt = $attempt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCachedDueDate(): ?\DateTimeInterface
    {
        return $this->cached_due_date;
    }

    /**
     * @param \DateTimeInterface|null $cached_due_date
     * @return Submission
     */
    public function setCachedDueDate(?\DateTimeInterface $cached_due_date): Submission
    {
        $this->cached_due_date = $cached_due_date;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getExcused(): ?bool
    {
        return $this->excused;
    }

    /**
     * @param bool|null $excused
     * @return Submission
     */
    public function setExcused(?bool $excused): Submission
    {
        $this->excused = $excused;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatePolicyStatus(): ?string
    {
        return $this->late_policy_status;
    }

    /**
     * @param string|null $late_policy_status
     * @return Submission
     */
    public function setLatePolicyStatus(?string $late_policy_status): Submission
    {
        $this->late_policy_status = $late_policy_status;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPointsDeducted(): ?float
    {
        return $this->points_deducted;
    }

    /**
     * @param float|null $points_deducted
     * @return Submission
     */
    public function setPointsDeducted(?float $points_deducted): Submission
    {
        $this->points_deducted = $points_deducted;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGradingPeriodId(): ?int
    {
        return $this->grading_period_id;
    }

    /**
     * @param int|null $grading_period_id
     * @return Submission
     */
    public function setGradingPeriodId(?int $grading_period_id): Submission
    {
        $this->grading_period_id = $grading_period_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getExtraAttempts(): ?int
    {
        return $this->extra_attempts;
    }

    /**
     * @param int|null $extra_attempts
     * @return Submission
     */
    public function setExtraAttempts(?int $extra_attempts): Submission
    {
        $this->extra_attempts = $extra_attempts;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->posted_at;
    }

    /**
     * @param \DateTimeInterface|null $posted_at
     * @return Submission
     */
    public function setPostedAt(?\DateTimeInterface $posted_at): Submission
    {
        $this->posted_at = $posted_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRedoRequest(): ?string
    {
        return $this->redo_request;
    }

    /**
     * @param string|null $redo_request
     * @return Submission
     */
    public function setRedoRequest(?string $redo_request): Submission
    {
        $this->redo_request = $redo_request;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomGradeStatusId(): ?int
    {
        return $this->custom_grade_status_id;
    }

    /**
     * @param int|null $custom_grade_status_id
     * @return Submission
     */
    public function setCustomGradeStatusId(?int $custom_grade_status_id): Submission
    {
        $this->custom_grade_status_id = $custom_grade_status_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSticker(): ?string
    {
        return $this->sticker;
    }

    /**
     * @param string|null $sticker
     * @return Submission
     */
    public function setSticker(?string $sticker): Submission
    {
        $this->sticker = $sticker;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLate(): ?bool
    {
        return $this->late;
    }

    /**
     * @param bool|null $late
     * @return Submission
     */
    public function setLate(?bool $late): Submission
    {
        $this->late = $late;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getMissing(): ?bool
    {
        return $this->missing;
    }

    /**
     * @param bool|null $missing
     * @return Submission
     */
    public function setMissing(?bool $missing): Submission
    {
        $this->missing = $missing;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecondsLate(): ?int
    {
        return $this->seconds_late;
    }

    /**
     * @param int|null $seconds_late
     * @return Submission
     */
    public function setSecondsLate(?int $seconds_late): Submission
    {
        $this->seconds_late = $seconds_late;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEnteredGrade(): ?string
    {
        return $this->entered_grade;
    }

    /**
     * @param string|null $entered_grade
     * @return Submission
     */
    public function setEnteredGrade(?string $entered_grade): Submission
    {
        $this->entered_grade = $entered_grade;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getEnteredScore(): ?float
    {
        return $this->entered_score;
    }

    /**
     * @param float|null $entered_score
     * @return Submission
     */
    public function setEnteredScore(?float $entered_score): Submission
    {
        $this->entered_score = $entered_score;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPreviewUrl(): ?string
    {
        return $this->preview_url;
    }

    /**
     * @param string|null $preview_url
     * @return Submission
     */
    public function setPreviewUrl(?string $preview_url): Submission
    {
        $this->preview_url = $preview_url;
        return $this;
    }


}
