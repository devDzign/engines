<?php

namespace App\Declaration\Model;

class DeclarationValue
{
    public function __construct(
        public string $id,
        public string $declarationId,
        public string $value,
        public string $formulaire,
        public string $zone,
        public string $type,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            declarationId: $data['declarationId'],
            value: $data['value'],
            formulaire: $data['formulaire'],
            zone: $data['zone'],
            type: $data['type'],
        );
    }
}