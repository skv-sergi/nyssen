<?php
// Tag and category archives (/tag/tag-name, /category/category-name).
// Bludit puts the pages in $content and sets up Paginator
// (pages per page = the "Items per page" setting).
if ($WHERE_AM_I == 'tag') {
    $archive = new Tag($url->slug());
    $archiveTitle = 'Posts tagged &ldquo;' . $archive->name() . '&rdquo;';
} else {
    $archive = new Category($url->slug());
    $archiveTitle = 'Posts in ' . $archive->name();
}
$postList = $content;
$postsPageNumber = Paginator::currentPage();
$postsNumberOfPages = Paginator::numberOfPages();
?>
<main id="maincontent" class="wrapper page">

    <section>
        <div class="container container-narrow padding-short">
            <div class="row">
                <div class="column">

                    <h1 class="page-title"><?php echo $archiveTitle; ?><?php if ($postsPageNumber > 1): ?><span class="page-title-page"><span class="visually-hidden">, </span>Page <?php echo $postsPageNumber; ?> of <?php echo $postsNumberOfPages; ?></span><?php endif; ?></h1>

                    <?php if (empty($postList)): ?>
                    <p>There are no posts here yet.</p>
                    <?php else: ?>
                        <?php include(THEME_DIR_PHP . 'partials/post-list.php'); ?>
                        <?php include(THEME_DIR_PHP . 'partials/post-pagination.php'); ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

</main>
