<?php
namespace Aoe\PicocontainerObjectManager\Object\Container;

use TYPO3\CMS\Extbase\Object\Container\Container as ExtbaseContainer;

class Container extends ExtbaseContainer
{
    /**
     * @var ClassInfoFactory
     */
    protected $bridgedClassInfoFactory;

    /**
     * @return ClassInfoFactory
     */
    protected function getClassInfoFactory()
    {
        return $this->bridgedClassInfoFactory;
    }

    /**
     * @param ClassInfoFactory $classInfoFactory
     */
    public function setBridgedClassInfoFactory(ClassInfoFactory $classInfoFactory)
    {
        $this->bridgedClassInfoFactory = $classInfoFactory;
    }
}
