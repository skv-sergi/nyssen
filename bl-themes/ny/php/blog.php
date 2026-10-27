<?php
// Blog page (the static page with the "blog" slug): its content, then the posts.
// Sticky posts go first. Posts per page = the "Items per page" setting.
$blogPosts = blogPosts();
$stickyPosts = array();
$otherPosts = array();
foreach ($blogPosts as $post) {
    if ($post->sticky()) {
        $stickyPosts[] = $post;
    } else {
        $otherPosts[] = $post;
    }
}
$blogPosts = array_merge($stickyPosts, $otherPosts);

$postsPerPage = $site->itemsPerPage();
$postsNumberOfPages = max(1, (int) ceil(count($blogPosts) / $postsPerPage));
$postsPageNumber = max(1, $url->pageNumber());
$postList = array_slice($blogPosts, ($postsPageNumber - 1) * $postsPerPage, $postsPerPage);
?>
<main id="maincontent" class="wrapper page">

    <section>
        <div class="container container-narrow padding-short">
            <div class="row">
                <div class="column">

                    <?php Theme::plugins('pageBegin'); // Load Bludit Plugins: Page Begin ?>

                    <h1 class="page-title"><?php echo $page->title(); ?><?php if ($postsPageNumber > 1 && !empty($postList)): ?><span class="page-title-page"><span class="visually-hidden">, </span>Page <?php echo $postsPageNumber; ?> of <?php echo $postsNumberOfPages; ?></span><?php endif; ?></h1>

                    <?php if ($postsPageNumber == 1): // Intro only on the first page ?>
                        <?php if ($page->coverImage()): ?>
                        <img class="cover-image" src="<?php echo $page->coverImage(); ?>" alt="<?php echo $page->custom('coverImageAlt'); ?>">
                        <?php endif ?>

                        <?php if ($page->content()): ?>
                        <div class="page-content"><?php echo $page->content(); ?></div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (empty($blogPosts)): ?>
                    <p>There are no posts yet.</p>
                    <?php elseif (empty($postList)): ?>
                    <p>There are no posts on this page. <a href="<?php echo $page->permalink(); ?>">See the latest posts</a>.</p>
                    <?php else: ?>
                        <?php include(THEME_DIR_PHP . 'partials/post-list.php'); ?>
                        <?php include(THEME_DIR_PHP . 'partials/post-pagination.php'); ?>
                    <?php endif; ?>

                    <?php Theme::plugins('pageEnd'); // Load Bludit Plugins: Page End ?>

                </div>
            </div>
        </div>
    </section>

</main>
