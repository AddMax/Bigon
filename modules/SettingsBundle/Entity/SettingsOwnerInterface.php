<?php

namespace kudin\SettingsBundle\Entity;

/**
 * This interface must be implemented by the Entity connected to a setting.
 */
interface SettingsOwnerInterface
{
    public function getSettingIdentifier();
}
