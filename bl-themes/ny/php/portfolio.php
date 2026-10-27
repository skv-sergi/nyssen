<!-- php/portfolio.php -->
<main id="maincontent" class="content inner cf">
    <article class="post post-excerpt">
        
        <!-- Load Bludit Plugins: Page Begin -->
        <?php Theme::plugins('pageBegin'); ?>
        
        <!-- Page title -->
        <h1 class="page-title"><?php echo $page->title(); ?></h1>
        
        <!-- Page cover image -->
        <?php if ($page->coverImage()): ?>
        <img class="cover-image" src="<?php echo $page->coverImage(); ?>" alt="<?php echo $page->custom('coverImageAlt'); ?>">
        <?php endif ?>
    
        <!-- Page content -->
        <div class="page-content"><?php echo $page->content(); ?></div>



        <?php
        // Get all child pages of 'portfolio' parent (including unpublished)
        global $pages;
        $parentKey = 'portfolio';
        $childPages = array();

        // Get list of all pages (including unpublished - change published parameter to false)
        $allPageKeys = $pages->getList(1, -1, false, true, false, false, false);

        // Filter to get only children of 'portfolio'
        foreach ($allPageKeys as $pageKey) {
            if ($pages->exists($pageKey)) {
                $tempPage = new Page($pageKey);
                if ($tempPage->parentKey() == $parentKey) {
                    $childPages[] = $pageKey;
                }
            }
        }

        // Display each child page
        foreach ($childPages as $pageKey) {
            $currentPage = new Page($pageKey);
            ?>
            <div class="embedded-page">
                <h2><?php echo $currentPage->title(); ?></h2>
                
                <!-- Page cover image (alt="": the h2 above already names the project) -->
                <?php if ($currentPage->coverImage()): ?>
                    <?php
                    // Get image path - coverImage() returns URL, we need the file path
                    $imageUrl = $currentPage->coverImage();
                    $imagePath = str_replace(DOMAIN_BASE, PATH_ROOT, $imageUrl);
                    
                    // Get image dimensions
                    $imageSize = @getimagesize($imagePath);
                    $width = $imageSize ? $imageSize[0] : '';
                    $height = $imageSize ? $imageSize[1] : '';
                    ?>
                    <img src="<?php echo $currentPage->coverImage(); ?>" 
                        alt=""
                        class="cover-image"
                        <?php if ($width && $height): ?>
                        width="<?php echo $width; ?>"
                        height="<?php echo $height; ?>"
                        <?php endif; ?>>
                <?php endif; ?>
                
                <?php echo $currentPage->content(); ?>
            </div>
            <?php
        }
        ?>

        
        
        <!-- Load Bludit Plugins: Page End -->
        <?php Theme::plugins('pageEnd'); ?>
        
    </article>
</main>