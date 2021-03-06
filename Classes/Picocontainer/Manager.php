<?php

class tx_picocontainer_IoC_manager
{
    /**
     * @var tx_picocontainer_IoC_manager
     */
    protected static $instance = null;

    /**
     * @var array
     */
    public static $singletons = [];

    /**
     * @var array
     */
    public static $parsedImplementations = [];

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private static $bridgedObjectManager;

    private function __construct()
    {
    }

    /**
     * @deprecated
     *
     * @return tx_picocontainer_IoC_manager
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @deprecated
     */
    public static function rereset()
    {
    }

    /**
     * @deprecated
     */
    public static function reset()
    {
    }

    /**
     * @deprecated
     *
     * @param string $objectName
     */
    public static function registerSingleton($objectName)
    {
        self::$singletons[] = $objectName;
    }

    /**
     * @deprecated
     *
     * @param string $objectName
     * @return object
     */
    public static function getSingleton($objectName)
    {
        self::registerImplementation($objectName);
        return self::getObjectManager()->get($objectName);
    }

    /**
     * @deprecated
     *
     * @param string $objectName
     */
    public static function registerPrototype($objectName)
    {
    }

    /**
     * @deprecated
     *
     * @param string $objectName
     * @return object
     */
    public static function create($objectName)
    {
        self::registerImplementation($objectName);
        return self::getObjectManager()->get($objectName);
    }

    /**
     * @return \Aoe\PicocontainerObjectManager\Object\ObjectManager
     */
    private static function getObjectManager()
    {
        if (self::$bridgedObjectManager === null) {
            \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->initializeTypo3DbGlobal();

            self::$bridgedObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \Aoe\PicocontainerObjectManager\Object\ObjectManager::class
            );
        }
        return self::$bridgedObjectManager;
    }

    /**
     * @param string $objectName
     */
    private static function registerImplementation($objectName)
    {
        if (!self::isImplementationAlreadyParsed($objectName) && class_exists($objectName)) {
            self::$parsedImplementations[] = $objectName;
            $reflectionClass = new ReflectionClass($objectName);
            $interfaces = $reflectionClass->getInterfaces();
            foreach ($interfaces as $interface) {
                /** @var \ReflectionClass $interface */
                /** @var \Aoe\PicocontainerObjectManager\Object\Container\Container $container */
                $container = self::getObjectManager()->get(
                    \Aoe\PicocontainerObjectManager\Object\Container\Container::class
                );
                $container->registerImplementation($interface->getName(), $objectName);
            }
        }
    }

    /**
     * @param string $objectName
     * @return bool
     */
    private static function isImplementationAlreadyParsed($objectName)
    {
        return in_array($objectName, self::$parsedImplementations);
    }
}
