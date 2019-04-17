<h2 class="font-semibold mb-10">Setup Node.JS & NPM</h2>

<p class="leading-loose mb-8">
    NPM is a package manager for the JavaScript programming language. It is the default package manager for the
    JavaScript runtime environment Node.js. We can install Node.js along with NPM automatically into the project and get
    it running instantly.
</p>

<p class="font-bold leading-loose mb-8">Click on Install button to proceed.</p>

<form action="<?php echo $routes->generate('nodejs.setup'); ?>" method="post">
    <div class="text-right">
        <button type="submit"
                class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
            Install
        </button>
    </div>
</form>