<main class="">

    <!-- Do Carousel -->
    <?php
        $carousel = new Carousel;
        $carousel->do_carousel();
    ?>

    <div class="container my-5 text-center lead">
        <div class="row justify-content-center">
            <div class="col-11 col-lg-6">
                <?=isset($page_data) ? $page_data['content'] : ''; ?>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row row-cols-lg-3 justify-content-center">
            <?php Feature::list_features('News', $params = ['limit' => 3]); ?>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-11 text-center">
                <?php Feature::list_features('Partner', $params = ['limit' => 3], 'partners-preview.html'); ?>
            </div>
        </div>
    </div>

</main>