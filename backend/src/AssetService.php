<?php

namespace App;

use App\Models\Asset;
use PDO;

class AssetService
{
    public function __construct(private PDO $db)
    {
    }

    public function getAssets(): array
    {
        $stmt = $this->db->query('SELECT * FROM assets ORDER BY created_at DESC');
        $rows = $stmt->fetchAll();

        return array_map(static fn (array $row) => Asset::fromArray($row), $rows);
    }

    public function createAsset(string $name, string $category, float $value, string $status, int $ownerId): Asset
    {
        $stmt = $this->db->prepare(
            'INSERT INTO assets (name, category, value, status, owner_id, created_at) VALUES (:name, :category, :value, :status, :owner_id, NOW())'
        );

        $stmt->execute([
            'name' => $name,
            'category' => $category,
            'value' => $value,
            'status' => $status,
            'owner_id' => $ownerId,
        ]);

        $id = (int) $this->db->lastInsertId();

        return new Asset($id, $name, $category, $value, $status, date('Y-m-d H:i:s'), $ownerId);
    }

    public function getTotalValue(): float
    {
        $stmt = $this->db->query('SELECT COALESCE(SUM(value), 0) AS total FROM assets');
        $row = $stmt->fetch();

        return (float) ($row['total'] ?? 0);
    }
}
