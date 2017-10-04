<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Decorator;

/**
 * The interface for the decorator handler.
 */
interface DecoratorInterface
{
    /**
     * Return if the entity is supported by the decorator manager.
     *
     * @param object $entity The decorator's entity
     *
     * @return bool If the entity is supported
     */
    public function supports($entity);
}
