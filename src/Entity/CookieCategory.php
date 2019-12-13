<?php

namespace Queo\CookieRegistry\Entity;

class CookieCategory implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var null|string
     */
    protected $description;
    /**
     * @var bool
     */
    protected $required;
    /**
     * @var bool
     */
    protected $approved;

    /**
     * CookieCategory constructor.
     *
     * @param string $key
     * @param string $name
     * @param string|null $description
     * @param bool $required
     * @param bool $approved
     */
    public function __construct(
        string $key,
        string $name = '',
        string $description = null,
        bool $required = false,
        bool $approved = false
    ) {
        $this->key         = $key;
        $this->name        = $name;
        $this->description = $description;
        $this->required    = $required;
        $this->approved    = $approved;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     */
    public function setApproved(bool $approved): void
    {
        $this->approved = $approved;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return
            [
                'key'         => $this->getKey(),
                'name'        => $this->getName(),
                'description' => $this->getDescription(),
                'required'    => $this->isRequired(),
                'approved'    => $this->isApproved()
            ];
    }
}