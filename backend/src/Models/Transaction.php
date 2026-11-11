<?php

namespace App\Models;

class Transaction
{
    public function __construct(
        public int $id,
        public int $assetId,
        public string $type,
        public float $amount,
        public string $createdAt
    ) {
    }
}
