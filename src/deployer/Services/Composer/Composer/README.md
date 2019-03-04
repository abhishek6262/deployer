# Composer
The PHP instance of Project-Level Composer.

This library allows you to install composer on your project making it possible for you to use composer even when it is not installed in the system. Moreover, You can consume the power of composer and its commands outside of the terminal as you normally do use any other PHP class.

[Read Blog Post.](https://www.shade.codes/introducing-project-level-composer/)

## Examples
```
require_once 'Path\To\Composer.php';

// $composer = new \abhishek6262\Composer\Composer('pathToProjectRoot', 'pathToBinDirectory');
$composer = new \abhishek6262\Composer\Composer(__DIR__);

if (! $composer->exists()) {
    $composer->install();
}

if ($composer->packagesExists() && ! $composer->packagesInstalled()) {
    $response = $composer->installPackages();

    if ($response->statusCode() == '0') {
        echo "Packages successfully installed.";
    } else {
        echo "Packages failed to install.";
    }

    print_r($response->output());
}
```

## Credits

- [Abhishek Prakash](https://github.com/abhishek6262)

## Contributing
Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities. I will appreciate that a lot. Also please add your name to the credits.

Kindly [follow me on twitter](https://twitter.com/_the_shade)!

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
