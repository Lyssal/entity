<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Decorator\Exception;

use Lyssal\Entity\Exception\EntityException;

/**
 * A decorator exception.
 */
class DecoratorException extends EntityException
{
    /**
     * Constructor.
     *
     * @param string $message The error message
     * @param int    $code    The error code
     */
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}
