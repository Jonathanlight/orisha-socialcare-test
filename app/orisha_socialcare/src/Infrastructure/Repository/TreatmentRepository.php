<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Treatment;
use App\Domain\Repository\TreatmentRepositoryInterface;
use App\Infrastructure\Database\DatabaseConnection;

class TreatmentRepository extends DatabaseConnection implements TreatmentRepositoryInterface
{
    /**
     * @param Treatment $treatment
     * @return int
     */
    public function create(Treatment $treatment): int
    {
        $stmt = self::getConnection()->prepare(
            'INSERT INTO treatments (resident_id, medication, dosage, schedule_time, start_date, end_date)
             VALUES (:resident_id, :medication, :dosage, :schedule_time, :start_date, :end_date)'
        );

        $stmt->execute([
            ':resident_id' => $treatment->getResidentId(),
            ':medication' => $treatment->getMedication(),
            ':dosage' => $treatment->getDosage(),
            ':schedule_time' => $treatment->getScheduleTime(),
            ':start_date' => $treatment->getStartDate()->format('Y-m-d'),
            ':end_date' => $treatment->getEndDate()?->format('Y-m-d'),
        ]);

        return (int) self::getConnection()->lastInsertId();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $stmt = self::getConnection()->prepare('SELECT * FROM treatments');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getByResident(int $residentId): array
    {
        $stmt = self::getConnection()->prepare('SELECT * FROM treatments WHERE resident_id = :resident_id');
        $stmt->execute([':resident_id' => $residentId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @param Treatment $treatment
     * @return bool
     */
    public function update(int $id, Treatment $treatment): bool
    {
        $stmt = self::getConnection()->prepare(
            'UPDATE treatments SET
                medication = :medication,
                dosage = :dosage,
                schedule_time = :schedule_time,
                start_date = :start_date,
                end_date = :end_date
             WHERE id = :id'
        );

        return $stmt->execute([
            ':medication' => $treatment->getMedication(),
            ':dosage' => $treatment->getDosage(),
            ':schedule_time' => $treatment->getScheduleTime(),
            ':start_date' => $treatment->getStartDate()->format('Y-m-d'),
            ':end_date' => $treatment->getEndDate()?->format('Y-m-d'),
            ':id' => $id,
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = self::getConnection()->prepare('DELETE FROM treatments WHERE id = :id');

        return $stmt->execute([':id' => $id]);
    }
}
