<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

/**
 * Interface QuizQuestionAnswerInterface
 * Defines the contract for a quiz question answer.
 */
interface NumericalInterface extends AnswerInterface
{
    /**
     * Get the type of numerical question.
     * Values can be 'exact_answer', 'range_answer', or 'precision_answer'.
     */
    public function getNumericalAnswerType(): ?string;

    /**
     * Set the type of numerical question.
     * Values can be 'exact_answer', 'range_answer', or 'precision_answer'.
     */
    public function setNumericalAnswerType(?string $numericalAnswerType): self;

    /**
     * Get the exact value required for an 'exact_answer' numerical question.
     */
    public function getExact(): ?float;

    /**
     * Set the exact value required for an 'exact_answer' numerical question.
     */
    public function setExact(?float $exact): self;

    /**
     * Get the margin of error allowed for an 'exact_answer' numerical question.
     */
    public function getMargin(): ?float;

    /**
     * Set the margin of error allowed for an 'exact_answer' numerical question.
     */
    public function setMargin(?float $margin): self;

    /**
     * Get the approximate value required for a 'precision_answer' numerical question.
     */
    public function getApproximate(): ?float;

    /**
     * Set the approximate value required for a 'precision_answer' numerical question.
     */
    public function setApproximate(?float $approximate): self;

    /**
     * Get the numerical precision used when comparing a 'precision_answer'.
     */
    public function getPrecision(): ?int;

    /**
     * Set the numerical precision used when comparing a 'precision_answer'.
     */
    public function setPrecision(?int $precision): self;

    /**
     * Get the start of the allowed range for a 'range_answer' numerical question (inclusive).
     */
    public function getStart(): ?float;

    /**
     * Set the start of the allowed range for a 'range_answer' numerical question (inclusive).
     */
    public function setStart(?float $start): self;

    /**
     * Get the end of the allowed range for a 'range_answer' numerical question (inclusive).
     */
    public function getEnd(): ?float;

    /**
     * Set the end of the allowed range for a 'range_answer' numerical question (inclusive).
     */
    public function setEnd(?float $end): self;

}
