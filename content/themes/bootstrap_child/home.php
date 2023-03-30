<main class="">

    <!-- Do Carousel -->
    <?php
        $carousel = new Carousel;
        $carousel->do_carousel();
    ?>


    <div class="container-fluid bg-custom-primary text-white">
        <div class="container py-5 text-center lead">
            <div class="row justify-content-center">
                <div class="col-11 text-white">
                    <p><i class="fas fa-calendar fa-fw fa-2x"></i></p>
                    <p id="countdown" class="m-0 display-6 text-white text-uppercase text-custom-font-title"></p>
                    <p class="small">to the symposium</p>
                    <a href="<?=BASE_URL ?>/activities/the-cameroon-alumni-national-symposium--2nd-editio" target="" class="btn btn-custom-accent-green px-5 text-uppercase fw-bold">Learn More and Apply</a>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-5 py-lg-5 text-center lead">
        <div class="row justify-content-center">

            <div class="col-11 col-lg-8 text-center">
                <div class="image" style="height:300px;">
                    <?=Run::post_image(ORG_DEFAULT_IMAGE); ?>
                </div>
            </div>

            <div class="col-11 col-lg-6 my-4 fw-bold">
                <?=defined('ORG_DESCRIPTION') ? ORG_DESCRIPTION : ''; ?>
            </div>
            
            <div class="col-lg-8">
                <?php Feature::list_features('Program', null, 'program-preview-logo.html'); ?>
            </div>

        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0 text-center">
                <a href="https://questionpro.com/t/AWcJ6Zwnta" target="_blank" class="btn btn-lg d-block btn-custom-accent-green py-5 text-uppercase fw-bold">Apply to attend the upcoming Symposium</a>
            </div>
        </div>
    </div>


    <div class="container my-5 py-5">
        <div class="row row-cols-lg-3 justify-content-center">

            <?php // Feature::list_features('News', $params = ['limit' => 3]); ?>

            <div class="col-lg-8 text-center">
                <h3 class="mb-4 text-custom-secondary text-uppercase">Our Partners & Sponsors</h3>
                <?php Feature::list_features('Partner', null, 'partners-preview.html'); ?>
            </div>
            
        </div>
    </div>


    <div class="container my-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h3 class="mb-4 text-custom-secondary text-uppercase">Follow Us on Social Media</h3>
                <?php Feature::list_features('Social', $params = ['limit' => 3]); ?>
            </div>
        </div>
    </div>

</main>