<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\Entity\EducationalPlan;

use Webmozart\Assert\Assert;

class FormEducation
{
    public const NAME = [
        'ochnaya-forma-polucheniya-obrazovaniya' => 'Очная форма получения образования',
        'zaochnaya-forma-polucheniya-obrazovaniya' => 'Заочная форма получения образования',
        'soiskatelstvo' => 'Соискательство'
    ];

    private $key;

    public function __construct(string $key)
    {
        Assert::oneOf($key, array_keys(self::NAME));

        $this->key = $key;
    }

    public function isEqual(self $other): bool
    {
        return $this->getKey() === $other->getKey();
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return self::NAME[$this->key];
    }

}
