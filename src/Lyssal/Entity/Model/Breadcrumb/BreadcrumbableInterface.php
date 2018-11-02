<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Model\Breadcrumb;

/**
 * Interface for generate breadcrumbs with entities.
 */
interface BreadcrumbableInterface
{
    /**
     * Get the parent.
     *
     * @return mixed|null The breadcrumb parent
     */
    public function getBreadcrumbParent();
}
