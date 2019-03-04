<div class="mb-6 mt-12">
    <div class="min-w-full">
        <div class="bg-white max-w-2x1 mx-auto overflow-hidden rounded shadow">
            <div class="flex">
                <div class="bg-grey-lighter w-1/4">
                    <div class="p-8">
                        <div class="bg-indigo font-bold rounded h-10 w-10 flex items-center justify-center mb-10 text-indigo-darkest">
                            D
                        </div>

                        <?php require_once 'recipe-list.php';?>
                    </div>
                </div>

                <div class="w-3/4">
                    <div class="p-8">
                        <div class="my-2">
                            <?php echo $this->response; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>