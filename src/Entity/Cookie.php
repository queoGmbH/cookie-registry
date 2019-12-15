<?php

namespace Queo\CookieRegistry\Entity;

use Queo\CookieRegistry\Entity\CookieCategory;
use Queo\CookieRegistry\Utility\Filter;

class Cookie implements \JsonSerializable
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $value;
    /** @var int */
    protected $expire;
    /** @var string */
    protected $domain;
    /** @var string */
    protected $path;
    /** @var bool */
    protected $secure;
    /** @var bool */
    protected $httpOnly;
    /** @var CookieCategory|string */
    protected $cookieCategory;
    /** @var string */
    protected $description;
    /** @var boolean */
    protected $isSet;
    /** @var boolean */
    protected $approved;

    /**
     * Cookie constructor.
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param CookieCategory|string|null $cookieCategory
     * @param string $domain
     * @param string $path
     * @param bool|null $httpOnly
     * @param bool $secure
     * @param string|null $description
     * @param bool $approved
     */
    public function __construct(
        $name,
        $value = null,
        $expire,
        $cookieCategory = null,
        $domain = "",
        $path = "/",
        $httpOnly = true,
        $secure = true,
        $description = null,
        $approved = false
    ) {
        $this->name        = $name;
        $this->value       = $value;
        $this->expire      = $expire;
        $this->domain      = $domain;
        $this->path        = $path;
        $this->httpOnly    = $httpOnly;
        $this->secure      = $secure;
        $this->description = $description;
        $this->approved    = $approved;

        // set values by existing Cookies
        if (array_key_exists($this->name, $_COOKIE)) {
            $this->value = $_COOKIE[$this->getName()];
            $this->setIsSet(true);
        } else {
            $this->setIsSet(false);
        }

        // set values by given CookieCategory
        if ($cookieCategory instanceof CookieCategory) {
            $this->cookieCategory = $cookieCategory;
            $this->approved       = $cookieCategory->isApproved();
        } else if (is_string($cookieCategory)) {
            $this->cookieCategory = Filter::getCookieCategoryByKey($cookieCategory);
            $this->approved       = $this->cookieCategory->isApproved();
        }
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
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     */
    public function setExpire($expire): void
    {
        $this->expire = $expire;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return bool
     */
    public function isSecure(): ?bool
    {
        return $this->secure;
    }

    /**
     * @param bool $secure
     */
    public function setSecure(bool $secure): void
    {
        $this->secure = $secure;
    }

    /**
     * @return bool
     */
    public function isHttpOnly(): ?bool
    {
        return $this->httpOnly;
    }

    /**
     * @param bool $httpOnly
     */
    public function setHttpOnly(bool $httpOnly): void
    {
        $this->httpOnly = $httpOnly;
    }

    /**
     * @return \Queo\CookieRegistry\Entity\CookieCategory|null
     */
    public function getCookieCategory(): ?\Queo\CookieRegistry\Entity\CookieCategory
    {
        return $this->cookieCategory;
    }

    /**
     * @param \Queo\CookieRegistry\Entity\CookieCategory $cookieCategory
     */
    public function setCookieCategory(\Queo\CookieRegistry\Entity\CookieCategory $cookieCategory): void
    {
        $this->cookieCategory = $cookieCategory;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
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
    public function isSet(): bool
    {
        return $this->isSet;
    }

    /**
     * @param bool $isSet
     */
    public function setIsSet(bool $isSet): void
    {
        $this->isSet = $isSet;
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
                'name'           => $this->getName(),
                'value'          => $this->getValue(),
                'expire'         => $this->getExpire(),
                'domain'         => $this->getDomain(),
                'path'           => $this->getPath(),
                'httpOnly'       => $this->isHttpOnly(),
                'secure'         => $this->isSecure(),
                'cookieCategory' => $this->getCookieCategory(),
                'description'    => $this->getDescription(),
                'isSet'          => $this->isSet(),
                'approved'       => $this->isApproved(),
            ];
    }
}
