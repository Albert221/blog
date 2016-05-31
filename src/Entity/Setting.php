<?php

namespace Albert221\Blog\Entity;

use DateTime;

/**
 * @Entity(repositoryClass="\Albert221\Blog\Repository\Database\SettingRepository") @Table(name="settings")
 */
class Setting
{
    const TYPE_VARCHAR = 0;
    const TYPE_INTEGER = 1;
    const TYPE_TEXT = 2;
    const TYPE_DATETIME = 3;
    const TYPE_BOOLEAN = 4;

    /**
     * @var int Id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string Name
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string Value
     * @Column(type="string")
     */
    protected $value;

    /**
     * @var int Type
     * @Column(type="integer")
     */
    protected $type;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        switch ($this->type) {
            case self::TYPE_INTEGER:
                return intval($this->value);
            case self::TYPE_DATETIME:
                return new DateTime($this->value);
            case self::TYPE_BOOLEAN:
                return boolval($this->value);
            default:
                return $this->value;
        }
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!in_array($type, [
            self::TYPE_VARCHAR,
            self::TYPE_INTEGER,
            self::TYPE_TEXT,
            self::TYPE_DATETIME,
            self::TYPE_BOOLEAN])) {
            throw new \InvalidArgumentException('Invalid type given.');
        }
        
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
