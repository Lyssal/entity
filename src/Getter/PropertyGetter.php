<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Getter;

use Lyssal\Entity\Exception\EntityException;

/**
 * Get an entity property.
 */
class PropertyGetter
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
     * Get a value to the entity property.
     *
     * @param string $property The entity property
     * @param array  $args     The method arguments
     *
     * @return mixed The property value
     *
     * @throws \Lyssal\Entity\Exception\EntityException If the getter method is not found
     */
    public function get($property, $args = [])
    {
        if (method_exists($this->entity, $property)) {
            $value = call_user_func_array(array($this->entity, $property), $args);
        } elseif (method_exists($this->entity, 'get'.ucfirst($property))) {
            $value = call_user_func_array([$this->entity, 'get'.ucfirst($property)], $args);
        } elseif (method_exists($this->entity, 'is'.ucfirst($property))) {
            $value = call_user_func_array([$this->entity, 'is'.ucfirst($property)], $args);
        } else {
            throw new EntityException('No getter function has been found for the property "'.$property.'" of the object "'.get_class($this->entity).'".');
        }

        return $value;
    }
}
