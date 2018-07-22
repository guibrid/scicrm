<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
 use App\Utility\Warnings;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warnings'), ['controller' => 'Warnings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warning'), ['controller' => 'Warnings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['controller' => 'Shortbrands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['controller' => 'Shortbrands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['controller' => 'Shortorigins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['controller' => 'Shortorigins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Edit Product') ?></legend>
        <?php
            $warning = new Warnings;
            echo $this->Form->control('code');
            echo $warning->warningDisplay($warningList , 'code');

            echo $this->Form->control('remplacement_product');
            echo $warning->warningDisplay($warningList , 'remplacement_product');

            echo $this->Form->control('title');
            echo $warning->warningDisplay($warningList , 'title');

            echo $this->Form->control('pcb');
            echo $warning->warningDisplay($warningList , 'pcb');

            echo $this->Form->control('prix');
            echo $warning->warningDisplay($warningList , 'prix');

            echo $this->Form->control('uv');
            echo $warning->warningDisplay($warningList , 'uv');

            echo $this->Form->control('poids');
            echo $warning->warningDisplay($warningList , 'poids');

            echo $this->Form->control('volume');
            echo $warning->warningDisplay($warningList , 'volume');

            echo $this->Form->control('dlv');
            echo $warning->warningDisplay($warningList , 'dlv');

            echo $this->Form->control('duree_vie');
            echo $warning->warningDisplay($warningList , 'duree_vie');

            echo $this->Form->control('gencod');
            echo $warning->warningDisplay($warningList , 'gencod');

            echo $this->Form->control('douanier');
            echo $warning->warningDisplay($warningList , 'douanier');

            echo $this->Form->control('dangereux');
            echo $warning->warningDisplay($warningList , 'dangereux');

            echo $this->Form->control('origin_id', ['options' => $origins]);
            echo $warning->warningDisplay($warningList , 'origin_id');

            echo $this->Form->control('tva');
            echo $warning->warningDisplay($warningList , 'tva');

            echo $this->Form->control('cdref');
            echo $warning->warningDisplay($warningList , 'cdref');

            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $warning->warningDisplay($warningList , 'category_code');

            echo $this->Form->control('subcategory_id', ['options' => $subcategories]);
            echo $warning->warningDisplay($warningList , 'subcategory_code');

            echo $this->Form->control('entrepot');
            echo $warning->warningDisplay($warningList , 'entrepot');

            echo $this->Form->control('supplier');
            echo $warning->warningDisplay($warningList , 'supplier');

            echo $this->Form->control('qualification');
            echo $warning->warningDisplay($warningList , 'qualification');

            echo $this->Form->control('couche_palette');
            echo $warning->warningDisplay($warningList , 'couche_palette');

            echo $this->Form->control('colis_palette');
            echo $warning->warningDisplay($warningList , 'colis_palette');

            echo $this->Form->control('pieceartk');
            echo $warning->warningDisplay($warningList , 'pieceartk');

            echo $this->Form->control('ifls_remplacement');
            echo $warning->warningDisplay($warningList , 'ifls_remplacement');

            echo $this->Form->control('assortiment');
            echo $warning->warningDisplay($warningList , 'assortiment');

            echo $this->Form->control('brand_id', ['options' => $brands]);
            echo $warning->warningDisplay($warningList , 'brand_id');

            echo $this->Form->control('active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
