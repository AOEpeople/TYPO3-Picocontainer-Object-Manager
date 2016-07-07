<?php
namespace Aoe\PicocontainerObjectManager\Object\Container;

use TYPO3\CMS\Extbase\Object\Container\ClassInfo;
use TYPO3\CMS\Extbase\Object\Container\ClassInfoFactory as ExtbaseClassInfoFactory;

class ClassInfoFactory extends ExtbaseClassInfoFactory
{
    /**
     * @param string $className
     * @return ClassInfo
     * @throws \TYPO3\CMS\Extbase\Object\Container\Exception\UnknownObjectException
     */
    public function buildClassInfoFromClassName($className)
    {
        $classInfo = parent::buildClassInfoFromClassName($className);
        return new ClassInfo(
            $classInfo->getClassName(),
            $classInfo->getConstructorArguments(),
            [],
            $classInfo->getIsSingleton(),// @todo: || in_array($className, \tx_picocontainer_IoC_manager::$singletons),
            $classInfo->getIsInitializeable(),
            []
        );
    }
}
