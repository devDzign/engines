<?php

namespace App\Declaration\Model;

use App\Core\Model\EngineModelInterface;

final readonly class Declaration implements EngineModelInterface
{
    /**
     * @param array<DeclarationValue>|null $values
     */
    public function __construct(
        public string $id,
        public ?string $status = null,
        public ?string $period = null,
        public ?string $formulaire = null,
        public ?\DateTime $startDate = null,
        public ?\DateTime $endDate = null,
        public ?int $millesime = null,
        public ?string $declarantSiren = null,
        public ?string $comment = null,
        public ?array $errors = null,
        public ?array $rib = null,
        public ?\DateTime $createdAt = null,
        public ?\DateTime $updatedAt = null,
        public ?\DateTime $deletedAt = null,
        public ?array $values = null,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     * @param array{
     *     id: string,
     *     status?: string,
     *     period?: string,
     *     formulaire?: string,
     *     startDate?: string,
     *     endDate?: string,
     *     millesime?: int,
     *     declarantSiren?: string,
     *     comment?: string,
     *     errors?: array,
     *     rib?: array,
     *     createdAt?: string,
     *     updatedAt?: string,
     *     deletedAt?: string,
     *     values?: array<array<string, mixed>>
     * } $data
     */
    public static function fromArray(array $data): self
    {
        $values = isset($data['values']) ? array_map(fn(array $value) => DeclarationValue::fromArray($value), $data['values']) : null;

        return new self(
            $data['id'],
            $data['status'] ?? null,
            $data['period'] ?? null,
            $data['formulaire'] ?? null,
            isset($data['startDate']) ? new \DateTime($data['startDate']) : null,
            isset($data['endDate']) ? new \DateTime($data['endDate']) : null,
            $data['millesime'] ?? null,
            $data['declarantSiren'] ?? null,
            $data['comment'] ?? null,
            $data['errors'] ?? null,
            $data['rib'] ?? null,
            isset($data['createdAt']) ? new \DateTime($data['createdAt']) : null,
            isset($data['updatedAt']) ? new \DateTime($data['updatedAt']) : null,
            isset($data['deletedAt']) ? new \DateTime($data['deletedAt']) : null,
            $values,
        );
    }
}