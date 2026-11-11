<?php

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/AssetService.php';
require_once __DIR__ . '/../src/Models/Asset.php';

use App\AssetService;
use App\Database;

$config = require __DIR__ . '/../config.php';

$errorMessage = null;

try {
    $database = new Database($config['db']);
    $service = new AssetService($database->getConnection());
    $assets = $service->getAssets();
    $total = $service->getTotalValue();
} catch (Throwable $exception) {
    $assets = [];
    $total = 0.0;
    $errorMessage = $exception->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $category = trim((string) ($_POST['category'] ?? ''));
    $value = (float) ($_POST['value'] ?? 0);
    $status = trim((string) ($_POST['status'] ?? 'active'));
    $ownerId = (int) ($_POST['owner_id'] ?? 1);

    if ($name !== '' && $category !== '') {
        try {
            $database = new Database($config['db']);
            $service = new AssetService($database->getConnection());
            $service->createAsset($name, $category, $value, $status, $ownerId);
            header('Location: /');
            exit;
        } catch (Throwable $exception) {
            $errorMessage = $exception->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de patrimoine</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f7fb; color: #1b1b1b; }
        .container { max-width: 1100px; margin: 0 auto; }
        .card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        form { display: grid; grid-template-columns: repeat(5, minmax(120px, 1fr)); gap: 12px; }
        input, select, button { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; }
        button { background: #2563eb; color: white; border: none; cursor: pointer; }
        .summary { display: flex; gap: 20px; flex-wrap: wrap; }
        .stat { flex: 1; background: #eff6ff; border-radius: 10px; padding: 16px; }
        .error { color: #b91c1c; background: #fee2e2; padding: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion de patrimoine</h1>

        <div class="summary">
            <div class="stat">
                <strong>Nombre d'actifs</strong><br>
                <?= count($assets); ?>
            </div>
            <div class="stat">
                <strong>Valeur totale</strong><br>
                <?= number_format($total, 2, ',', ' '); ?> €
            </div>
        </div>

        <div class="card">
            <h2>Ajouter un bien</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Nom du bien" required>
                <input type="text" name="category" placeholder="Catégorie" required>
                <input type="number" name="value" step="0.01" min="0" placeholder="Valeur" required>
                <select name="status">
                    <option value="active">Actif</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="sold">Vendu</option>
                </select>
                <button type="submit">Enregistrer</button>
            </form>
        </div>

        <?php if ($errorMessage !== null): ?>
            <div class="error">Erreur : <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Liste des actifs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Valeur</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td><?= htmlspecialchars($asset->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($asset->category, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= number_format($asset->value, 2, ',', ' '); ?> €</td>
                            <td><?= htmlspecialchars($asset->status, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($asset->createdAt, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
