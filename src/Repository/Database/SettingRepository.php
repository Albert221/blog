<?php

namespace Albert221\Blog\Repository\Database;

use Albert221\Blog\Entity\Setting;
use Albert221\Blog\Repository\SettingRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;

class SettingRepository extends EntityRepository implements SettingRepositoryInterface
{
    /**
     * @var array Settings
     */
    protected $settings;

    public function offsetExists($offset)
    {
        if (is_null($this->settings)) {
            $this->loadSettings();
        }
        
        return isset($this->settings[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new InvalidArgumentException(sprintf('Setting \'%s\' cannot be found.', $offset));
        }
        
        return $this->settings[$offset];
    }

    public function offsetSet($offset, $value)
    {
        // Do nothing
    }

    public function offsetUnset($offset)
    {
        // Do nothing
    }

    protected function loadSettings()
    {
        $settings = [];

        array_walk($this->findAll(), function (Setting $setting) use (&$settings) {
            $settings[$setting->getName()] = $setting;
        });

        $this->settings = $settings;
    }
}
