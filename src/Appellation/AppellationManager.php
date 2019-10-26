<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Appellation;

use Lyssal\Entity\Decorator\DecoratorInterface;
use Lyssal\Entity\Appellation\Exception\AppellationException;

/**
 * the appellations' manager.
 */
class AppellationManager
{
    /**
     * @var \Lyssal\Entity\Appellation\AppellationInterface[] The appellation handlers
     */
    protected $appellationHandlers = array();


    /**
     * Constructor.
     */
    public function __construct()
    {

    }


    /**
     * Add an appellation handler.
     *
     * @param \Lyssal\Entity\Appellation\AppellationInterface $appellationHandler The appellation handler
     */
    public function addAppellationHandler(AppellationInterface $appellationHandler)
    {
        $this->appellationHandlers[] = $appellationHandler;
    }

    /**
     * Get the appellation of the object.
     *
     * @param object $object The object
     * @return string The appellation
     * @throws \Lyssal\Entity\Appellation\Exception\AppellationException If the parameter is not an object
     * @throws \Lyssal\Entity\Appellation\Exception\AppellationException If the object has not a __toString method and if the appellation handler has not been called
     */
    public function appellation($object)
    {
        foreach ($this->appellationHandlers as $appellationHandler) {
            if ($appellationHandler->supports($object)) {
                return $appellationHandler->appellation($object);
            }
        }

        if (!is_object($object)) {
            throw new AppellationException('The value for the appellation is not an object (type "'.gettype($object).'" found).');
        }

        if (method_exists($object, '__toString')) {
            return (string) $object;
        }

        if ($object instanceof DecoratorInterface) {
            try {
                return $this->appellation($object->getEntity());
            } catch (AppellationException $e) {
                throw new AppellationException('The appellation handler has not been called for "'.get_class($object).'" and the class has not a __toString method.');
            }

        }

        throw new AppellationException('The appellation handler has not been called for "'.get_class($object).'" and the class has not a __toString method.');
    }

    /**
     * Get the HTML appellation of the object.
     *
     * @param object $object The object
     * @return string The HTML appellation
     * @throws \Lyssal\Entity\Appellation\Exception\AppellationException If the appellation does not exist
     */
    public function appellationHtml($object)
    {
        foreach ($this->appellationHandlers as $appellationHandler) {
            if ($appellationHandler->supports($object)) {
                return $appellationHandler->appellationHtml($object);
            }
        }

        return $this->appellation($object);
    }
}
