<?php require('partials/head.php'); ?>
<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <form method="POST" action="/short-links">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <label
                                    for="target"
                                    class="block text-sm font-medium text-gray-700"
                                >Shorten a long URL</label>

                                <div class="mt-1">
                                    <input
                                        id="target"
                                        name="target"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Enter long link here..."
                                        value="<?= sessionHas('target') ? sessionGet('target') : '' ?>"
                                    >

                                    <?php if (sessionHas('link_id')) : ?>
                                        <input
                                            id="link"
                                            class="mt-2 text-indigo-600 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            value="<?= $basePath . 'r/' . encode(sessionGet('link_id')); ?>"
                                            readonly
                                        >
                                    <?php endif; ?>

                                    <?php if (sessionHas('errors')) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= sessionGet('errors')['target'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <?php if (! sessionHas('link_id')) : ?>
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Shorten URL
                                </button>
                            <?php else: ?>
                                <input type="hidden" name="another">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Shorten another
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto mt-8 shadow sm:overflow-hidden sm:rounded-md">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8 space-y-6 bg-white px-4 py-5 sm:p-6">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Original URL
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Short URL</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of clicks</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of unique clicks</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php if ($links): foreach ($links as $link) : ?>
                        <tr>
                            <td class="whitespace-nowrap px-3 py-4 text-left text-sm font-medium">
                                <a target="_blank" href="<?= $link['original_url']; ?>" class="text-indigo-600 hover:text-indigo-900"><?= mb_strimwidth($link['original_url'], 0, 60, '...'); ?></a>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium">
                                <a target="_blank" href="<?= $basePath . 'r/' . encode($link['slid']); ?>" class="text-indigo-600 hover:text-indigo-900"><?= $basePath . 'r/' .encode($link['slid']); ?></a>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $link['total_clicks'] ?? 0; ?></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $link['unique_clicks'] ?? 0; ?></td>
                        </tr>
                    <?php endforeach;
                    else: ?>
                        <tr colspan="4">
                            <td class="whitespace-nowrap px-3 py-4 text-left text-sm font-medium">No short link created yet...</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<?php require('partials/footer.php'); ?>
