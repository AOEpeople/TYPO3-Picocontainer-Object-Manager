<?php
namespace Aoe\PicocontainerObjectManager\Object;

use Aoe\PicocontainerObjectManager\Object\Container\ClassInfoFactory;
use Aoe\PicocontainerObjectManager\Object\Container\Container;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager as ExtbaseObjectManager;

class ObjectManager extends ExtbaseObjectManager
{
    /**
     * @var Container
     */
    protected $objectContainer;

    public function __construct()
    {
        parent::__construct();
        $this->objectContainer = GeneralUtility::makeInstance(Container::class);
        $this->objectContainer->setBridgedClassInfoFactory(new ClassInfoFactory());
    }
}
