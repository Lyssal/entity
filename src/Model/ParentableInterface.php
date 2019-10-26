<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Model;

/**
 * Interface for entities which can have one parent.
 */
interface ParentableInterface
{
    /**
     * Get the parent.
     *
     * @return mixed|null The parent
     */
    public function getParent();
}
