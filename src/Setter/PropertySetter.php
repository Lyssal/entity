<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Setter;

use Lyssal\Entity\Exception\EntityException;

/**
 * Change an entity property.
 */
class PropertySetter
{
    /**
     * @var object $entity The entity
     */
    protected $entity;


    /**
     * The constructor.
     *
     * @param object $entity The entity
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the entity is not an object
     */
    public function __construct($entity)
    {
        if (!is_object($entity)) {
            throw new EntityException('The entity is not an object (type "'.gettype($entity).'" found).');
        }

        $this->entity = $entity;
    }


    /**
     * Set a value to the entity property or set many values.
     *
     * @param string|array $propertyOrPropertyValues The entity property or an associative array with values for each property
     * @param mixed|null   $value                    The property value or null if the first argument is an associative array
     *
     * @return object The modified entity
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the arguments are invalid
     * @throws \Lyssal\Entity\Exception\EntityException If the setter method is not found
     */
    public function set($propertyOrPropertyValues, $value = null)
    {
        if ((is_string($propertyOrPropertyValues) && null === $value) || (is_array($propertyOrPropertyValues) && null !== $value)) {
            throw new EntityException('The arguments are invalid. Only use an associative array or a property string and its value.');
        }

        if (is_string($propertyOrPropertyValues)) {
            return $this->setOneProperty($propertyOrPropertyValues, $value);
        }
        return $this->setProperties($propertyOrPropertyValues);
    }

    /**
     * Set property values to the entity.
     *
     * @param array $values An associative array with values for each property
     *
     * @return object The modified entity
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the setter method is not found
     */
    protected function setProperties($values)
    {
        foreach ($values as $property => $value) {
            $this->setOneProperty($property, $value);
        }

        return $this->entity;
    }

    /**
     * Set a value to the entity property.
     *
     * @param string $property The entity property
     * @param mixed  $value    The property value
     *
     * @return object The modified entity
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the setter method is not found
     */
    protected function setOneProperty($property, $value)
    {
        if (method_exists($this->entity, $property)) {
            call_user_func_array(array($this->entity, $property), [$value]);
        } elseif (method_exists($this->entity, 'set'.ucfirst($property))) {
            call_user_func_array([$this->entity, 'set'.ucfirst($property)], [$value]);
        } else {
            throw new EntityException('No setter function has been found for the property "'.$property.'" of the object "'.get_class($this->entity).'".');
        }

        return $this->entity;
    }
}
