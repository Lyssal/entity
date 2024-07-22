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
use Traversable;

/**
 * the appellations' manager.
 */
class AppellationManager
{
    /**
     * @var \Lyssal\Entity\Appellation\AppellationInterface[] The appellations
     */
    protected $appellations = array();


    /**
     * Add appellations.
     *
     * @param \Lyssal\Entity\Appellation\AppellationInterface[] $appellations The appellations
     */
    public function addAppellations(Traversable $appelations): void
    {
        foreach ($appelations as $appelation) {
            $this->addAppellation($appelation);
        }
    }

    /**
     * Add an appellation.
     *
     * @param \Lyssal\Entity\Appellation\AppellationInterface $appellation The appellation
     */
    public function addAppellation(AppellationInterface $appellation)
    {
        $this->appellations[] = $appellation;
    }

    /**
     * Get the appellation of the object.
     *
     * @param object $object The object
     * @return string The appellation
     * @throws \Lyssal\Entity\Appellation\Exception\AppellationException If the parameter is not an object
     * @throws \Lyssal\Entity\Appellation\Exception\AppellationException If the object has not a __toString method and if the appellation has not been called
     */
    public function appellation($object)
    {
        $appellationService = $this->getAppellationService($object);

        if (null !== $appellationService) {
            return $appellationService->appellation($object);
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
                throw new AppellationException('The appellation has not been called for "'.get_class($object).'" and the class has not a __toString method.');
            }

        }

        throw new AppellationException('The appellation has not been called for "'.get_class($object).'" and the class has not a __toString method.');
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
        $appellationService = $this->getAppellationService($object);

        if (null !== $appellationService) {
            return $appellationService->appellationHtml($object);
        }

        return $this->appellation($object);
    }

    /**
     * Get the appellation service of the object.
     *
     * @param object $object The object
     *
     * @return AppellationInterface The appellation service
     */
    protected function getAppellationService($object): ?AppellationInterface
    {
        foreach ($this->appellations as $appellation) {
            if ($appellation->supports($object)) {
                return $appellation;
            }
        }

        return null;
    }
}
