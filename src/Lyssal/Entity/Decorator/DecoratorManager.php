<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Decorator;

use ArrayAccess;
use Lyssal\Entity\Decorator\Exception\DecoratorException;
use Traversable;

/**
 * the decorators' manager.
 */
class DecoratorManager
{
    /**
     * @var \Lyssal\Entity\Decorator\DecoratorInterface[] The decorator handlers
     */
    protected $decoratorHandlers = array();


    /**
     * Add a decorator handler.
     *
     * @param \Lyssal\Entity\Decorator\DecoratorInterface $decoratorHandler The decorator handler
     */
    public function addDecoratorHandler(DecoratorInterface $decoratorHandler)
    {
        $this->decoratorHandlers[] = $decoratorHandler;
    }

    /**
     * Return if the entity is supported by the decorator manager.
     *
     * @param object|object[] $oneOrManyEntities One or many entities
     * @return bool If the entity is supported
     */
    public function isSupportedEntity($oneOrManyEntities)
    {
        if (is_array($oneOrManyEntities) || $oneOrManyEntities instanceof Traversable) {
            $atLeastOneEntity = false;
            foreach ($oneOrManyEntities as $entity) {
                if (!$this->isSupportedEntity($entity)) {
                    return false;
                }
                $atLeastOneEntity = true;
            }
            return $atLeastOneEntity;
        }

        foreach ($this->decoratorHandlers as $decoratorHandler) {
            if ($decoratorHandler->supports($oneOrManyEntities)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the decorator of one or many entities.
     *
     * @param object|object[] $oneOrManyEntities One or many entities
     * @return \Lyssal\Entity\Decorator\DecoratorInterface|\Lyssal\Entity\Decorator\DecoratorInterface[] The decorator(s)
     * @throws \Lyssal\Entity\Decorator\Exception\DecoratorException If the entity is not an object
     * @throws \Lyssal\Entity\Decorator\Exception\DecoratorException If the decorator handler has not been called
     */
    public function get($oneOrManyEntities)
    {
        if (
            is_array($oneOrManyEntities)
            || $oneOrManyEntities instanceof ArrayAccess
            || $oneOrManyEntities instanceof Traversable
        ) {
            return $this->getArray($oneOrManyEntities);
        }

        foreach ($this->decoratorHandlers as $decoratorHandler) {
            if ($decoratorHandler->supports($oneOrManyEntities)) {
                // Clone to avoid references and return the same objects
                $decoratorClone = clone $decoratorHandler;
                $decoratorClone->setEntity($oneOrManyEntities);
                return $decoratorClone;
            }
        }

        if (!is_object($oneOrManyEntities)) {
            throw new DecoratorException('The value for the decorator is not an object (type "'.gettype($oneOrManyEntities).'" found).');
        }

        throw new DecoratorException('The entity decorator handler has not been called for "'.get_class($oneOrManyEntities).'".');
    }

    /**
     * Get the decorators of the entities.
     *
     * @see \Lyssal\Entity\Decorator\DecoratorManager::get()
     *
     * @param array|\ArrayAccess|\Traversable $entities The entities
     *
     * @throws \Lyssal\Entity\Decorator\Exception\DecoratorException If the parameter is not managed
     */
    protected function getArray($entities)
    {
        if (is_array($entities) || $entities instanceof ArrayAccess) {
            $decorators = [];

            foreach ($entities as $i => $entity) {
                $decorators[$i] = $this->get($entity);
            }

            return $decorators;
        }

        if ($entities instanceof Traversable) {
            $decorators = [];

            foreach ($entities as $i => $entity) {
                $decorators[] = $this->get($entity);
            }

            return $decorators;
        }

        throw new DecoratorException('The entities parameter is not a managed array or traversable.');
    }
}
