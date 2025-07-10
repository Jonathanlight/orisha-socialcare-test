<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Manager\TreatmentManager;
use App\Domain\Entity\Treatment;
use App\Domain\Repository\TreatmentRepositoryInterface;

class TreatmentManagerTest extends TestCase
{
    private TreatmentRepositoryInterface $repository;
    private TreatmentManager $manager;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(TreatmentRepositoryInterface::class);
        $this->manager = new TreatmentManager($this->repository);
    }

    public function testCreateSuccess(): void
    {
        $data = [
            'resident_id' => 1,
            'medication' => 'Paracetamol',
            'dosage' => '500mg',
            'schedule_time' => '08:00',
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-10'
        ];

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Treatment::class))
            ->willReturn(123);

        $result = $this->manager->create($data);
        $this->assertEquals(123, $result);
    }

    public function testCreateWithMissingDataThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->manager->create([
            'resident_id' => 1,
            // medication manquant
            'dosage' => '100mg',
            'schedule_time' => '10:00',
            'start_date' => '2025-07-01'
        ]);
    }
}
