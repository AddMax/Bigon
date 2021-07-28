<?php

namespace Evercode\DependentSelectBundle\Service;

/**
 * Interface DependentFieldSelectedOptionInterface
 */
interface DependentFieldSelectedOptionInterface
{
    /**
     * Returns an option id of entity which should be selected by default
     * (only if selected_result_service is defined in the config.yml).
     *
     * @param array $entities
     * @return int
     */
    public function findOptionIdToSelect(array $entities);
}