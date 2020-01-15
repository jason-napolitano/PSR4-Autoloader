<?php

/**
 * PSR-4 based autoloader
 */
abstract class Autoloader
{
    /**
     * PSR4 namespace array
     *
     * @var array $psr4
     */
    public static array $psr4 = [
        // ...
    ];

    /**
     * PSR4 classmap array
     *
     * @var array $classmap
     */
    public static array $classmap = [
        // ...
    ];

    /**
     * Map of class name prefixes
     *
     * @var array
     */
    public static array $prefixes = [
        // ...
    ];

    // --------------------------------------------------------------------

    /**
     * Register the autoloader functionality
     *
     * @return void
     */
    public static function register(): void
    {
        // Run the SPL autoloader
        spl_autoload_register([self::class, 'loadClass']);

        // Iterate through the PSR4 namespace array
        $namespaces = array_filter(self::$psr4);
        if ( ! empty($namespaces) ) {
            foreach ( self::$psr4 as $psr4 => $path ) {
                self::addNamespace($psr4, $path);
            }
        }
        // Iterate through the PSR4 classmap array
        $classmap = array_filter(self::$classmap);
        if ( ! empty($classmap) ) {
            foreach ( self::$classmap as $class => $file) {
                self::requireFiles(strpos($file, '.php')? $file: $file . '.php');
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Adds a namespace to the autoloader
     *
     * @param string $prefix
     * @param string $base_dir
     * @param bool   $prepend
     *
     * @return void
     */
    public static function addNamespace(string $prefix, string $base_dir, bool $prepend = false): void
    {
        // normalize namespace prefix
        $prefix = trim($prefix, '\\') . '\\';
        // normalize the base directory with a trailing separator
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';
        // initialize the namespace prefix array
        if ( isset(self::$prefixes[$prefix]) === false ) {
            self::$prefixes[$prefix] = [];
        }
        // retain the base directory for the namespace prefix
        if ( $prepend ) {
            array_unshift(self::$prefixes[$prefix], $base_dir);
        } else {
            self::$prefixes[$prefix][] = $base_dir;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Loads a class from the autoloader
     *
     * @param string $class
     *
     * @return bool|string
     */
    public static function loadClass(string $class)
    {
        // the current namespace prefix
        $prefix = $class;
        while ( false !== $pos = strrpos($prefix, '\\') ) {
            // retain the trailing namespace separator in the prefix
            $prefix = substr($class, 0, $pos + 1);
            // the rest is the relative class name
            $relative_class = substr($class, $pos + 1);
            // try to load a mapped file for the prefix and relative class
            $mapped_file = self::loadMappedFile($prefix, $relative_class);
            if ( $mapped_file ) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Loads a mapped file from the autoloader
     *
     * @param string $prefix
     * @param string $relative_class
     *
     * @return bool|string
     */
    protected static function loadMappedFile(string $prefix, string $relative_class)
    {
        // are there any base directories for this namespace prefix?
        if ( isset(self::$prefixes[$prefix]) === false ) {
            return false;
        }
        foreach ( self::$prefixes[$prefix] as $base_dir ) {
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
            // if the mapped file exists, require it
            if ( self::requireFiles($file) ) {
                // yes, we're done
                return $file;
            }
        }
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Require a file or an array of files
     *
     * @param string $files
     *
     * @return bool
     */
    public static function requireFiles(string $files): bool
    {
        if ( file_exists($files) ) {
            require $files;
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------
}
