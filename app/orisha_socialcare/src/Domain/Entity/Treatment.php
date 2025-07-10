<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Treatment
{
    public function __construct(
        private int $residentId,
        private string $medication,
        private string $dosage,
        private string $scheduleTime,
        private \DateTimeImmutable $startDate,
        private ?\DateTimeImmutable $endDate = null,
        private ?int $id = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResidentId(): int
    {
        return $this->residentId;
    }

    public function getMedication(): string
    {
        return $this->medication;
    }

    public function getDosage(): string
    {
        return $this->dosage;
    }

    public function getScheduleTime(): string
    {
        return $this->scheduleTime;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
