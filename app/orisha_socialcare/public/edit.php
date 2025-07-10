<?php
require __DIR__ . '/../bootstrap.php';

use App\Application\Manager\TreatmentManager;

$manager = new TreatmentManager();

if (!isset($_GET['id'])) {
    die("ID de traitement manquant.");
}
$id = (int) $_GET['id'];

// Traitement du formulaire POST (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $manager->update($id, $_POST);
        header('Location: /');
        exit;
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

// Récupérer les infos actuelles
$residentId = (int) ($_GET['resident_id'] ?? 0);
$treatments = $manager->getByResident($residentId);
$found = null;
foreach ($treatments as $tr) {
    if ((int)$tr['id'] === $id) {
        $found = $tr;
        break;
    }
}
if (!$found) {
    die("Traitement non trouvé.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Modifier le traitement</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
<h1 class="mb-4">Modifier un traitement</h1>

<?php if (!empty($error)): ?>
	<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
	<div class="mb-3">
		<label for="resident_id" class="form-label">ID Résident</label>
		<input type="number" name="resident_id" id="resident_id" class="form-control"
		       value="<?= htmlspecialchars($found['resident_id']) ?>" required>
	</div>
	<div class="mb-3">
		<label for="medication" class="form-label">Médicament</label>
		<input type="text" name="medication" id="medication" class="form-control"
		       value="<?= htmlspecialchars($found['medication']) ?>" required>
	</div>
	<div class="mb-3">
		<label for="dosage" class="form-label">Dosage</label>
		<input type="text" name="dosage" id="dosage" class="form-control"
		       value="<?= htmlspecialchars($found['dosage']) ?>" required>
	</div>
	<div class="mb-3">
		<label for="schedule_time" class="form-label">Heure de prise</label>
		<input type="time" name="schedule_time" id="schedule_time" class="form-control"
		       value="<?= htmlspecialchars($found['schedule_time']) ?>" required>
	</div>
	<div class="mb-3">
		<label for="start_date" class="form-label">Date de début</label>
		<input type="date" name="start_date" id="start_date" class="form-control"
		       value="<?= htmlspecialchars($found['start_date']) ?>" required>
	</div>
	<div class="mb-3">
		<label for="end_date" class="form-label">Date de fin</label>
		<input type="date" name="end_date" id="end_date" class="form-control"
		       value="<?= htmlspecialchars($found['end_date']) ?>">
	</div>
	<button type="submit" class="btn btn-success">Enregistrer</button>
	<a href="index.php?resident_id=<?= htmlspecialchars($found['resident_id']) ?>" class="btn btn-secondary">Annuler</a>
</form>
</body>
</html>
