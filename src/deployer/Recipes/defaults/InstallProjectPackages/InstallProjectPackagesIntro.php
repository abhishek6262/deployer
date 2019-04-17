<?php

$packages = '';

if ($composer->packagesExists()) {
    $packages .= '<li class="my-2">Composer packages</li>';
}

if ($npm->packagesExists()) {
    $packages .= '<li class="my-2">Node modules</li>';
}

?>

<h2 class="font-semibold mb-10">Install Packages</h2>

<p class="leading-loose mb-8">
    Most of the projects comprises of packages help them complete the functionalities. Packages provides the solution to
    the famous problem of <span class="font-bold">"Don't reinvent the wheel"</span>. We honour the decision and help the
    developers to setup the packages in the project automatically. This project is based upon:
</p>

<ul class="mb-8"><?php echo $packages; ?></ul>

<p class="font-bold leading-loose mb-8">Click on Install button to proceed.</p>

<form action="<?php echo $routes->generate('packages.setup'); ?>" method="post">
    <div class="text-right">
        <button type="submit"
                class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
            Install
        </button>
    </div>
</form>
