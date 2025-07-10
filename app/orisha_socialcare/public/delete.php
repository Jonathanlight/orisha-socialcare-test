<?php
require __DIR__ . '/../bootstrap.php';

use App\Application\Manager\TreatmentManager;

$manager = new TreatmentManager();

if (!isset($_GET['id'])) {
    die("ID du traitement manquant.");
}

$id = (int) $_GET['id'];

try {
    $manager->delete($id);
} catch (Throwable $e) {
    die("Erreur lors de la suppression : " . $e->getMessage());
}

header('Location: /');
exit;
