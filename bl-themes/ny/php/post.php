<?php
// Single blog post (a child page of the blog page)
$blogPosts = blogPosts();
$postKeys = array_map(function ($post) {
    return $post->key();
}, $blogPosts);
$postIndex = array_search($page->key(), $postKeys); // FALSE for draft previews
$newerPost = ($postIndex !== false && $postIndex > 0) ? $blogPosts[$postIndex - 1] : null;
$olderPost = ($postIndex !== false && $postIndex < count($blogPosts) - 1) ? $blogPosts[$postIndex + 1] : null;
$postTags = $page->tags(true);
?>
<main id="maincontent" class="wrapper post">

    <section>
        <div class="container container-x-narrow padding-short">
            <div class="row">
                <div class="column column-7"></div>
                <div class="column">

                    <?php Theme::plugins('pageBegin'); // Load Bludit Plugins: Page Begin ?>

                    <article class="post">

                        <header class="post-header">
                            <h1 class="page-title"><?php echo $page->title(); ?></h1>
                            <p class="post-meta"><time datetime="<?php echo $page->date('Y-m-d'); ?>"><?php echo $page->date(); ?></time><?php if ($page->category()): ?> in <a href="<?php echo $page->categoryPermalink(); ?>"><?php echo $page->category(); ?></a><?php endif; ?></p>
                        </header>

                        <?php if ($page->coverImage()): ?>
                        <img class="cover-image" src="<?php echo $page->coverImage(); ?>" alt="<?php echo $page->custom('coverImageAlt'); ?>">
                        <?php endif ?>

                        <div class="page-content"><?php echo $page->content(); ?></div>

                        <?php if (!empty($postTags)): ?>
                        <footer class="post-footer">
                            <p class="post-tags">Tags:
                                <?php
                                $tagLinks = array();
                                foreach ($postTags as $tagKey => $tagName) {
                                    $tagLinks[] = '<a rel="tag" href="' . DOMAIN_TAGS . $tagKey . '">' . $tagName . '</a>';
                                }
                                echo implode(', ', $tagLinks);
                                ?>
                            </p>
                        </footer>
                        <?php endif; ?>

                    </article>

                    <?php Theme::plugins('pageEnd'); // Load Bludit Plugins: Page End ?>

                    <?php if ($newerPost || $olderPost): ?>
                    <nav class="post-nav" aria-label="More posts">
                        <?php if ($newerPost): ?>
                        <a class="post-nav__link post-nav__prev" href="<?php echo $newerPost->permalink(); ?>"><span><span class="visually-hidden">Newer post: </span><?php echo $newerPost->title(); ?></span></a>
                        <?php endif; ?>
                        <?php if ($olderPost): ?>
                        <a class="post-nav__link post-nav__next" href="<?php echo $olderPost->permalink(); ?>"><span><span class="visually-hidden">Older post: </span><?php echo $olderPost->title(); ?></span></a>
                        <?php endif; ?>
                    </nav>
                    <?php endif; ?>

                </div>
                <div class="column column-7"></div>
            </div>
        </div>
    </section>

</main>
