<?php

require __DIR__ . '/../bootstrap.php';

use App\Application\Manager\TreatmentManager;

$manager = new TreatmentManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    try {
        $id = $manager->create($_POST);
        $message = "Traitement enregistré avec succès (ID: $id)";
    } catch (Throwable $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}

$treatments = isset($_GET['resident_id']) ? $manager->getByResident((int) $_GET['resident_id']) :  $manager->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Traitements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
<h1 class="mb-4">Gestion des traitements médicamenteux</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" class="mb-4">
    <input type="hidden" name="action" value="create">
    <div class="mb-3">
        <label for="resident_id" class="form-label">ID Résident</label>
        <input type="number" name="resident_id" id="resident_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="medication" class="form-label">Médicament</label>
        <input type="text" name="medication" id="medication" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="dosage" class="form-label">Dosage</label>
        <input type="text" name="dosage" id="dosage" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="schedule_time" class="form-label">Heure de prise</label>
        <input type="time" name="schedule_time" id="schedule_time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="start_date" class="form-label">Date de début</label>
        <input type="date" name="start_date" id="start_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="end_date" class="form-label">Date de fin</label>
        <input type="date" name="end_date" id="end_date" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Créer un traitement</button>
</form>

<hr>

<h2>Liste des traitements</h2>
<form method="get" class="mb-3">
    <div class="input-group">
        <input type="number" name="resident_id" placeholder="ID Résident" class="form-control" required>
        <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
    </div>
</form>

<?php if (!empty($treatments)): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Médicament</th>
            <th>Dosage</th>
            <th>Heure</th>
            <th>Début</th>
            <th>Fin</th>
	        <th>Modifier</th>
	        <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($treatments as $tr): ?>
            <tr>
                <td><?= htmlspecialchars($tr['id']) ?></td>
                <td><?= htmlspecialchars($tr['medication']) ?></td>
                <td><?= htmlspecialchars($tr['dosage']) ?></td>
                <td><?= htmlspecialchars($tr['schedule_time']) ?></td>
                <td><?= htmlspecialchars($tr['start_date']) ?></td>
                <td><?= htmlspecialchars($tr['end_date'] ?? '-') ?></td>
	            <td><a href="edit.php?id=<?= $tr['id'] ?>&resident_id=<?= $tr['resident_id'] ?>" class="btn btn-primary">Modifier</a></td>
	            <td><a href="delete.php?id=<?= $tr['id'] ?>" class="btn btn-danger">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($_GET['resident_id'])): ?>
    <div class="alert alert-warning">Aucun traitement trouvé pour ce résident.</div>
<?php endif; ?>
</body>
</html>