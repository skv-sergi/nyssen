<main id="maincontent" class="wrapper page">

    <section>
        <div class="container container-narrow padding-short">
            <div class="row">
                <div class="column">
        
                    <?php Theme::plugins('pageBegin'); // Load Bludit Plugins: Page Begin ?>
                    
                    <h1 class="page-title"><?php echo $page->title(); ?></h1>
                    
                    <?php if ($page->coverImage()): ?>
                    <img class="cover-image" src="<?php echo $page->coverImage(); ?>" alt="<?php echo $page->custom('coverImageAlt'); ?>">
                    <?php endif ?>
                
                    <div class="page-content"><?php echo $page->content(); ?></div>


                    <?php Theme::plugins('pageEnd'); // Load Bludit Plugins: Page End ?>
        
                </div>
            </div>
        </div>
    </section>
</main>