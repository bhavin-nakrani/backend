<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait MetaDetailEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $metaTitle;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $metaKeyword;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $metaDescription;

    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaKeyword(): string
    {
        return $this->metaKeyword;
    }

    public function setMetaKeyword(string $metaKeyword): self
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param mixed $metaDescription
     */
    public function setMetaDescription($metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }
}
