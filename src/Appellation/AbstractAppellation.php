<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Appellation;

/**
 * The abstract appellation handler
 */
abstract class AbstractAppellation implements AppellationInterface
{
    /**
     * AbstractAppellation constructor.
     */
    public function __construct()
    {

    }


    /**
     * Return the HTML appelation of the object.
     *
     * @param object $object The object
     * @return string The HTML appellation
     */
    public function appellationHtml($object)
    {
        return $this->appellation($object);
    }
}
