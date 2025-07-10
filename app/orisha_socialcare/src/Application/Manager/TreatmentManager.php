<?php

declare(strict_types=1);

namespace App\Application\Manager;

use App\Domain\Entity\Treatment;
use App\Domain\Repository\TreatmentRepositoryInterface;

readonly class TreatmentManager
{
    public function __construct(private TreatmentRepositoryInterface $repository)
    {
    }

    /**
     * @param array{
     *     resident_id: int|string,
     *     medication: string,
     *     dosage: string,
     *     schedule_time: string,
     *     start_date: string,
     *     end_date?: string|null
     * } $data
     * @return int
     * @throws \DateMalformedStringException
     */
    public function create(array $data): int
    {
        $treatment = $this->buildTreatmentFromArray($data);

        return $this->repository->create($treatment);
    }

    /**
     * @param int $id
     * @param array{
     *     resident_id: int|string,
     *     medication: string,
     *     dosage: string,
     *     schedule_time: string,
     *     start_date: string,
     *     end_date?: string|null
     * } $data
     * @return bool
     * @throws \DateMalformedStringException
     */
    public function update(int $id, array $data): bool
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('ID de traitement manquant.');
        }

        $treatment = $this->buildTreatmentFromArray($data);

        return $this->repository->update($id, $treatment);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('ID de traitement manquant.');
        }

        return $this->repository->delete($id);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getByResident(int $residentId): array
    {
        if (empty($residentId)) {
            throw new \InvalidArgumentException('ID de resident manquant.');
        }

        return $this->repository->getByResident($residentId);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * @param array{
     *     resident_id: int|string,
     *     medication: string,
     *     dosage: string,
     *     schedule_time: string,
     *     start_date: string,
     *     end_date?: string|null
     * } $data
     * @return Treatment
     * @throws \DateMalformedStringException
     */
    private function buildTreatmentFromArray(array $data): Treatment
    {
        if (empty($data['resident_id']) || empty($data['medication']) || empty($data['dosage']) || empty($data['schedule_time']) || empty($data['start_date'])) {
            throw new \InvalidArgumentException('Données incomplètes pour le traitement.');
        }

        return new Treatment(
            residentId: (int) $data['resident_id'],
            medication: ucfirst(trim($data['medication'])),
            dosage: trim($data['dosage']),
            scheduleTime: $data['schedule_time'],
            startDate: new \DateTimeImmutable($data['start_date']),
            endDate: !empty($data['end_date']) ? new \DateTimeImmutable($data['end_date']) : null
        );
    }
}
