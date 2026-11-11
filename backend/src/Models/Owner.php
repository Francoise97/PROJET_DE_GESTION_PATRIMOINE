<?php

namespace App\Models;

class Owner
{
    public function __construct(
        public int $id,
        public string $fullName,
        public string $email,
        public string $phone
    ) {
    }
}
