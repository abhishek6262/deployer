<?php

if (!function_exists('base_uri')) {
    /**
     * Returns the base uri of the deployer application.
     *
     * @return string
     */
    function base_uri(): string
    {
        return rtrim($_SERVER['SCRIPT_NAME'], '/index.php');
    }
}

if (!function_exists('normalize_pascal_case')) {
    /**
     * Returns the normalized version of the Pascal Case string.
     *
     * @param string $input
     *
     * @return string
     */
    function normalize_pascal_case(string $input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        $words = implode(' ', $ret);

        return ucwords($words);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirects the user to the given route.
     *
     * @param string $route
     * @return mixed
     */
    function redirect(string $route)
    {
        header('Location: ' . $route);
        exit;
    }
}

if (!function_exists('r_rmdir')) {
    /**
     * Removes all files and directories inside the given path.
     *
     * @param string $dir
     * @param array $exclude
     *
     * @return void
     */
    function r_rmdir(string $dir, array $exclude = [])
    {
        if (is_dir($dir) && !in_array(__ROOT_DIRECTORY__ . '/' . $dir, $exclude)) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if (!in_array(__ROOT_DIRECTORY__ . '/' . $file, $exclude)) {
                    if ($file != '.' && $file != '..') {
                        r_rmdir("$dir/$file");
                    }
                }
            }

            if (__ROOT_DIRECTORY__ !== $dir) {
                rmdir($dir);
            }
        } else if (file_exists($dir)) {
            unlink($dir);
        }
    }
}

if (!function_exists('r_copy')) {
    /**
     * Copies all the files and directories inside from the path to the
     * given destination.
     *
     * @param string $src
     * @param string $dest
     * @param array $exclude
     *
     * @return void
     */
    function r_copy(string $src, string $dest, array $exclude = [])
    {
        if (file_exists($dest) && __ROOT_DIRECTORY__ !== $dest) {
            r_rmdir($dest);
        }

        if (is_dir($src)) {
            if (__ROOT_DIRECTORY__ !== $dest) {
                mkdir($dest);
            }

            $files = scandir($src);

            foreach ($files as $file) {
                if (!in_array(__ROOT_DIRECTORY__ . '/' . $file, $exclude)) {
                    if ($file != '.' && $file != '..') {
                        r_copy("$src/$file", "$dest/$file");
                    }
                }
            }
        } else if (file_exists($src)) {
            copy($src, $dest);
        }
    }
}
