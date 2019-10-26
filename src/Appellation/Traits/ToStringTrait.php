<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Appellation\Traits;

/**
 * Trait qui utilise la méthode __toString d'un objet pour ses appellations.
 */
trait ToStringTrait
{
    /**
     * Return the simple appelation of the object.
     *
     * @param object $object The object
     *
     * @return string The appellation
     */
    public function appellation($object)
    {
        return $object->__toString();
    }

    /**
     * Return the HTML appelation of the object.
     *
     * @param object $object The object
     *
     * @return string The HTML appellation
     */
    public function appellationHtml($object)
    {
        return $this->appellation($object);
    }
}
