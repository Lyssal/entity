<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Decorator;

use Lyssal\Entity\Getter\PropertyGetter;

/**
 * The abstract decorator handler
 */
abstract class AbstractDecorator implements DecoratorInterface
{
    /**
     * \Lyssal\Entity\Decorator\DecoratorManager The decorator manager
     */
    protected $decoratorManager;

    /**
     * @var object The entity
     */
    protected $entity;


    /**
     * Constructor.
     *
     * @param \Lyssal\Entity\Decorator\DecoratorManager $decoratorManager The decorator manager
     */
    public function __construct(DecoratorManager $decoratorManager)
    {
        $this->decoratorManager = $decoratorManager;
    }


    /**
     * @see \Lyssal\Entity\Decorator\DecoratorInterface::setEntity()
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @see \Lyssal\Entity\Decorator\DecoratorInterface::getEntity()
     */
    public function getEntity()
    {
        return $this->entity;
    }


    /**
     * Process the getters ans the setters.
     *
     * @param string $name The function or property name
     * @param array  $args The method arguments
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the entity is not an object
     * @throws \Lyssal\Entity\Decorator\Exception\DecoratorException If any getter has been found for the property
     *
     * @return \Lyssal\Entity\Decorator\DecoratorInterface The decorator object
     */
    public function __call($name, $args)
    {
        $propertyGetter = new PropertyGetter($this->entity);
        $value = $propertyGetter->get($name, $args);

        if (!($value instanceof DecoratorInterface) && $this->decoratorManager->isSupportedEntity($value)) {
            return $this->decoratorManager->get($value);
        }

        return $value;
    }

    /**
     * Get the entity string.
     *
     * @return string The string
     */
    public function __toString()
    {
        return (string) $this->entity;
    }
}
