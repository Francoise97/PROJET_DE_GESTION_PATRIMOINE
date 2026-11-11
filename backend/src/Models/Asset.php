<?php

namespace App\Models;

class Asset
{
    public function __construct(
        public int $id,
        public string $name,
        public string $category,
        public float $value,
        public string $status,
        public string $createdAt,
        public ?int $ownerId = null
    ) {
    }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) ($row['id'] ?? 0),
            (string) ($row['name'] ?? ''),
            (string) ($row['category'] ?? ''),
            (float) ($row['value'] ?? 0),
            (string) ($row['status'] ?? 'active'),
            (string) ($row['created_at'] ?? ''),
            isset($row['owner_id']) ? (int) $row['owner_id'] : null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'value' => $this->value,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'owner_id' => $this->ownerId,
        ];
    }
}
