<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Appellation;

/**
 * The interface for the appellation handler.
 */
interface AppellationInterface
{
    /**
     * Return if the object is supported by the appelation manager.
     *
     * @param object $object The appellation's object
     *
     * @return bool If the object is supported
     */
    public function supports($object);

    /**
     * Return the simple appelation of the object.
     *
     * @param object $object The object
     *
     * @return string The appellation
     */
    public function appellation($object);

    /**
     * Return the HTML appelation of the object.
     *
     * @param object $object The object
     *
     * @return string The HTML appellation
     */
    public function appellationHtml($object);
}
