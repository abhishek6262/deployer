<?php

$c_status = filter_var(@$_GET['composer'], FILTER_VALIDATE_INT);
$n_status = filter_var(@$_GET['npm'], FILTER_VALIDATE_INT);

$packages = '';

if ($c_status !== false && $c_status === 1) {
    $packages .= '<li class="my-2">Failed to install composer packages.</li>';
}

if ($n_status !== false && $n_status === 1) {
    $packages .= '<li class="my-2">Failed to install node modules.</li>';
}

?>

<h2 class="font-semibold mb-10">Install Packages</h2>

<p class="leading-loose mb-8">
    Some error occured while installing the packages. It could be the faulty composer.json/package.json file(s) or there
    might be some issue with the permissions in the directories of the project.
</p>

<ul class="mb-8"><?php echo $packages; ?></ul>

<p class="font-bold leading-loose mb-8">
    You can try to install the packages manually. Once done, please click on the
    Skip button to continue.
</p>

<div class="text-right">
    <a href="<?php echo $routes->nextViewRouteUrl(); ?>"
       class="bg-transparent hover:bg-indigo-dark border border-grey hover:border-indigo-dark font-bold inline-block py-2 px-4 rounded text-grey-darker hover:text-white">
        Skip
    </a>
</div>