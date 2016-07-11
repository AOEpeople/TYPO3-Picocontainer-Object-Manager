<?php
namespace Aoe\PicocontainerObjectManager\Object\Container;

use TYPO3\CMS\Extbase\Object\Container\ClassInfo;
use TYPO3\CMS\Extbase\Object\Container\ClassInfoFactory as ExtbaseClassInfoFactory;
use TYPO3\CMS\Extbase\Object\Container\Exception\UnknownObjectException;

class ClassInfoFactory extends ExtbaseClassInfoFactory
{
    /**
     * @param string $className
     * @return ClassInfo
     * @throws UnknownObjectException
     */
    public function buildClassInfoFromClassName($className)
    {
        try {
            $reflectedClass = new \ReflectionClass($className);
        } catch (\Exception $e) {
            throw new UnknownObjectException(
                'Could not analyse class:' . $className . ' maybe not loaded or no autoloader?',
                1468249648
            );
        }
        return new ClassInfo(
            $className,
            $this->getConstructorArgs($reflectedClass),
            [],
            $this->isSingleton($reflectedClass) || in_array($className, \tx_picocontainer_IoC_manager::$singletons),
            $this->isInitializable($reflectedClass),
            []
        );
    }

    /**
     * @param \ReflectionClass $reflectedClass
     * @return array
     */
    private function getConstructorArgs(\ReflectionClass $reflectedClass)
    {
        $factory = new \ReflectionClass($this);
        $method = $factory->getMethod('getConstructorArguments');
        $method->setAccessible(true);
        return $method->invoke($this, $reflectedClass);
    }

    /**
     * @param \ReflectionClass $reflectedClass
     * @return bool
     */
    private function isSingleton(\ReflectionClass $reflectedClass)
    {
        $factory = new \ReflectionClass($this);
        $method = $factory->getMethod('getIsSingleton');
        $method->setAccessible(true);
        return $method->invoke($this, $reflectedClass);
    }

    /**
     * @param \ReflectionClass $reflectedClass
     * @return bool
     */
    private function isInitializable(\ReflectionClass $reflectedClass)
    {
        $factory = new \ReflectionClass($this);
        $method = $factory->getMethod('getIsInitializeable');
        $method->setAccessible(true);
        return $method->invoke($this, $reflectedClass);
    }
}
