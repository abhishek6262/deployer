<h2 class="font-semibold mb-10">Setup Database</h2>

<p class="leading-loose mb-8">
    Below you should enter your database connection details. If you're not sure about these contact your host.
</p>

<?php if (! empty($error)) : ?>
<div class="bg-red-lightest border-l-4 border-red text-red-dark p-4 mb-8" role="alert">
    <p><?php echo $error; ?></p>
</div>
<?php endif; ?>

<form class="w-full" action="<?php echo $routes->generate('database.setup'); ?>" method="post">
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-database-name">
                Database Name
            </label>

            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="grid-database-name" type="text" name="name">
            <p class="text-grey-dark text-xs italic">The name of the database you want to use with Project.</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-database-host">
                Database Host
            </label>

            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-database-host" type="text" placeholder="localhost" value="localhost" name="host">
            <p class="text-grey-dark text-xs italic">You should be able to get this info from your host, if localhost doesn't work.</p>
        </div>

        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-database-port">
                Database Port
            </label>

            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-database-port" type="text" placeholder="3306" value="3306" name="port">
            <p class="text-grey-dark text-xs italic">You should be able to get this info from your host, if 3306 doesn't work.</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-database-username">
                Database Username
            </label>

            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-database-username" type="text" name="user">
            <p class="text-grey-dark text-xs italic">Your database username.</p>
        </div>

        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-database-password">
                Database Password
            </label>

            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-database-password" type="text" name="pass">
            <p class="text-grey-dark text-xs italic">Your database password.</p>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
            Proceed
        </button>
    </div>
</form>