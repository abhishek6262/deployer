<h2 class="font-semibold mb-10">Setup Composer</h2>

<p class="leading-loose mb-8">
    Composer is an application-level package manager for the PHP programming language that provides a standard format
    for managing dependencies of PHP software and required libraries. We can install Composer automatically into the
    project and get it running instantly.
</p>

<p class="font-bold leading-loose mb-8">Click on Install button to proceed.</p>

<form action="<?php $routes->generate('composer.setup'); ?>" method="post">
    <div class="text-right">
        <button type="submit"
                class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
            Install
        </button>
    </div>
</form>