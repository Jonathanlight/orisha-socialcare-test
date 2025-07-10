<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Treatment;

interface TreatmentRepositoryInterface
{
    /**
     * @param Treatment $treatment
     * @return int
     */
    public function create(Treatment $treatment): int;

    /**
     * @param int $id
     * @param Treatment $treatment
     * @return bool
     */
    public function update(int $id, Treatment $treatment): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getByResident(int $residentId): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array;
}
