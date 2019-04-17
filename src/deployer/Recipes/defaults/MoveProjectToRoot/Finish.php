<div class="flex items-center mb-12 mt-24">
    <div class="mx-auto">
        <div class="bg-white max-w-xs overflow-hidden p-8 rounded shadow-sm">
            <div class="mb-5">
                <div class="bg-indigo-lighter font-bold rounded-full h-16 w-16 flex items-center justify-center mb-6">
                    F
                </div>

                <div class="font-bold text-xl mb-4">Finish.</div>

                <p class="leading-loose text-base text-grey-darker">
                    Thanks for using Deployer. We have successfully run the recipes on your application.
                </p>
                
                <p class="font-bold leading-loose text-base text-grey-darker mt-4">
                    Click on proceed to continue to the application.
                </p>
            </div>

            <form action="<?php echo $routes->generate('finish.setup'); ?>" method="post">
                <div>
                    <button type="submit"
                            class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
                        Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>