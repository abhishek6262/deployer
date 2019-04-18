# Deployer [![Build Status](https://travis-ci.com/abhishek6262/deployer.svg?token=9nGqp1ZjPVGihSfDfz2W&branch=master)](https://travis-ci.com/abhishek6262/deployer)

This application is responsible for setting up the PHP applications with ease, as it brings all the deployment tasks to the GUI-Level.

The deployer has been built upon the concept of the recipes where it assumes that only the chef knows which selective ingredients to use to cook the delicious dish. Where a chef prepares the recipe and then it pass it to another or use it on their own in future to follow the same instructions given in the recipe and get their same delicious dish (project) as the result.

## Screenshots

![Home Page](/screenshots/home.png)
![Recipes Page](/screenshots/recipes.png)

## Installation

The deployer can be interated with your application simply by placing the application into the `src` directory of the deployer after cloning the deployer application into your system.

___Please note: Move the deployer application out of the first `src` directory since the very root directory after cloning is for the documentation, license, & tests purpose.___

## Recipe

To write a recipe you just need to extend the base recipe class and provide deployer some extra information about it, those are:

**Recipe Name** - The recipe should be given its own directory (TitleCase) with a file of the same name as of the directory followed by the **Recipe** prefix in the filename. Such as: **recipes/RecipeName/RecipeNameRecipe.php**. Deployer uses the directory name of the recipe while listing it in the front-end. If you'd like to show different name then you can just place a new name in the `public $name = 'New Recipe Name';` variable inside the recipe.

`public $order = 5000;` - An order tells the deployer about when or after which recipe the newly created recipe will get executed. _Please note: `order` value before 5000 has been reserved for the deployer default recipes._

`public function routes(): array;` - A recipe will always return a list of routes with at least 1 GET/View route on which it will do its operations.

`public $composerPackages = [];` - There are times when a recipe will require some composer packages to be installed for it use. In which case you can add package name into the list of `$composerPackages` array of the recipe and the deployer will install them automatically for you.

`public $npmPackages = [];` - There are times when a recipe will require some npm packages to be installed for it use. In which case you can add package name into the list of `$npmPackages` array of the recipe and the deployer will install them automatically for you.

**Database** - Some recipes requires database connection to do their operation which they can request from the container passed to the recipe as the argument.

`$database = $container->resolve('database');`

It is also expected there are times when a project might need to import the database sql file as well to run it in which you can place the **database.sql** file in the root of the src directory and the deployer will automatically import it while setting up the database connection.

**Template** - In case, the recipe wants to use a template file to show data on the screen then they can use the `Template` class which takes the absolute path of the template that you want to use.

### Example

**recipes/RecipeName/RecipeNameRecipe.php**

```
<?php

use Deployer\Container;
use Deployer\Recipes\Recipe;
use Deployer\Recipes\RecipeCollection;
use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class RecipeNameRecipe
 */
class RecipeNameRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 5000;

    /**
     * The list of routes for the recipe.
     *
     * @return array
     */
    public function routes(): array
    {
        return [
            [
                'GET',
                'route',
                function (RouteCollection $routes, Container $container, RecipeCollection $recipes) {
                    // $route     = $routes->generate('route.name');
                    // $nextRoute = $routes->nextViewRouteUrl();

                    // Operations ...

                    // $response = new Template(
                    //    __DIR__ . '/TemplateName.php',
                    //    [
                    //        'routes' => $routes
                    //    ]
                    // );

                    // return new View($response);
                },
                'route.name'
            ],
        ];
    }
}
```

## Known Bugs

- Node.js does not install in windows.

## Credits

- [Abhishek Prakash](https://github.com/abhishek6262)

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities. I will appreciate that a lot. Also please add your name to the credits.

Kindly [follow me on twitter](https://twitter.com/_the_shade)!

## Support

Moreover, To keep this and my other open source projects ongoing You can also support me on Patreon by clicking on the button below.

[<img src="https://c5.patreon.com/external/logo/become_a_patron_button.png">](https://www.patreon.com/bePatron?u=5563585)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
