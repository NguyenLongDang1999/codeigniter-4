<!-- categories -->
<div class="col-lg-3 d-lg-block d-none">
        <div class="categories">
            <h2 class="categories__title"><?= lang('App.frontend.catHome.allCat'); ?> </h2>

            <ul class="categories__all m-0 list-unstyled">
                <?php $listSubCatalog = $mcatalog->catalogSubCatalog() ?>
                <?php foreach ($listSubCatalog as $item) { ?>
                    <?php $listSubCatalog1 = $mcatalog->catalogSubCatalog($item['id']) ?>
                    <li class="cat__accordion-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item['slug']) ?>"><?= $item['name'] ?></a>
                            <?php if ($listSubCatalog1) { ?>
                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <?php } ?>
                        </div>

                        <?php if ($listSubCatalog1) { ?>
                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                <?php foreach ($listSubCatalog1 as $item1) { ?>
                                    <?php $listSubCatalog2 = $mcatalog->catalogSubCatalog($item1['id']) ?>
                                    <li class="cat__accordion-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item1['slug']) ?>"><?= $item1['name'] ?></a>
                                            <?php if ($listSubCatalog2) { ?>
                                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>

                                        <?php if ($listSubCatalog2) { ?>
                                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                                <?php foreach ($listSubCatalog2 as $item2) { ?>
                                                    <li>
                                                        <a href="<?= base_url('danh-muc/' . $item2['slug']) ?>" class="cat__accordion-link"><?= $item2['name'] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>

            <?= $this->renderSection('detail'); ?>

        </div>
    </div>
    <!-- end categories -->

    <div class="col-12 d-lg-none d-block mobile__categories">
        <a href="javascript:void(0)" class="mobile__cat">
            <i class="fa fa-align-left" aria-hidden="true"></i>
            <?= lang('App.frontend.catHome.allCat'); ?>
        </a>

        <div class="categories categories-hide">
            <ul class="categories__all m-0 list-unstyled">
                <li>
                    <a href="javascript:void(0)" class="d-block text-right p-2 text-black-50 categories__mobile-times">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </li>
                <?php $listSubCatalog = $mcatalog->catalogSubCatalog() ?>
                <?php foreach ($listSubCatalog as $item) { ?>
                    <?php $listSubCatalog1 = $mcatalog->catalogSubCatalog($item['id']) ?>
                    <li class="cat__accordion-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item['slug']) ?>"><?= $item['name'] ?></a>
                            <?php if ($listSubCatalog1) { ?>
                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <?php } ?>
                        </div>

                        <?php if ($listSubCatalog1) { ?>
                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                <?php foreach ($listSubCatalog1 as $item1) { ?>
                                    <?php $listSubCatalog2 = $mcatalog->catalogSubCatalog($item1['id']) ?>
                                    <li class="cat__accordion-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item1['slug']) ?>"><?= $item1['name'] ?></a>
                                            <?php if ($listSubCatalog2) { ?>
                                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>

                                        <?php if ($listSubCatalog2) { ?>
                                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                                <?php foreach ($listSubCatalog2 as $item2) { ?>
                                                    <li>
                                                        <a href="<?= base_url('danh-muc/' . $item2['slug']) ?>" class="cat__accordion-link"><?= $item2['name'] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>