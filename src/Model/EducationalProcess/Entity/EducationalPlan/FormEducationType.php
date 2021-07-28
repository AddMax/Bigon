<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\Entity\EducationalPlan;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class FormEducationType extends StringType
{
    public const NAME = 'educational_process_plan_forma';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof FormEducation ? $value->getKey() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new FormEducation($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}