<?php
// Newer/older links for a paginated list of posts.
// Expects $postsPageNumber and $postsNumberOfPages.
if ($postsNumberOfPages > 1): ?>
<nav class="post-nav" aria-label="Pagination">
    <?php if ($postsPageNumber > 1): ?>
    <a class="post-nav__link post-nav__prev" rel="prev" href="<?php echo blogListPageUrl($postsPageNumber - 1); ?>"><span>Newer posts</span></a>
    <?php endif; ?>
    <?php if ($postsPageNumber < $postsNumberOfPages): ?>
    <a class="post-nav__link post-nav__next" rel="next" href="<?php echo blogListPageUrl($postsPageNumber + 1); ?>"><span>Older posts</span></a>
    <?php endif; ?>
</nav>
<?php endif; ?>
