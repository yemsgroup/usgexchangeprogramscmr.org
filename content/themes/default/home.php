<main class="">

    <!-- Do Carousel -->
    <?php
        $carousel = new Carousel;
        $carousel->do_carousel();
    ?>

    <div class="d-block">
        <?=isset($page_data) ? $page_data['content'] : ''; ?>
    </div>

    <div class="d-flex">
        <?php Feature::list_features('News', $params = ['limit' => 3]); ?>
    </div>

    <div class="d-flex">
        <?php Feature::list_features('Partner', $params = ['limit' => 3], 'partners-preview.html'); ?>
    </div>

</main>