<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Model\Breadcrumb;

/**
 * A breadcrumb.
 */
class Breadcrumb
{
    /**
     * @var string The label
     */
    protected $label;

    /**
     * @var string The link
     */
    protected $link;


    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Breadcrumb
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Breadcrumb
     */
    public function setLink(?string $link)
    {
        $this->link = $link;

        return $this;
    }
}
