<ul class="list-reset">
    <?php
        foreach ($collection->recipes() as $recipe) {
            $name = $recipe->name;

            if (empty($name)) {
                $name = trim(basename(get_class($recipe)));

                if (substr($name, -6) === 'Recipe') {
                    $name = substr($name, 0, -6);
                }

                $name = normalize_pascal_case($name);
            }
    ?>

    <li class="my-2 select-none">
        <?php if ($collection->isRecipeActive($recipe)): ?>
            <span class="bg-indigo border border-indigo flex items-center leading-normal px-3 py-1 rounded text-white">
                <span class="bg-white h-2 inline-block mr-2 rounded-full w-2"></span> <?php echo $name; ?>
            </span>
        <?php elseif ($collection->isRecipeCompleted($recipe)): ?>
            <span class="bg-transparent border border-transparent flex items-center leading-normal px-3 py-1 rounded text-indigo">
                <span class="bg-indigo h-2 inline-block mr-2 rounded-full w-2"></span> <?php echo $name; ?>
            </span>
        <?php else: ?>
            <span class="bg-transparent border border-transparent flex items-center leading-normal px-3 py-1 rounded text-indigo-darker">
                <span class="bg-indigo-darker h-2 inline-block mr-2 rounded-full w-2"></span> <?php echo $name; ?>
            </span>
        <?php endif;?>
    </li>

    <?php } ?>
</ul>