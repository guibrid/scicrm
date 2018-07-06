<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
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
        <legend><?= __('Add Product') ?></legend>
        <?php
            echo $this->Form->control('code');
            echo $this->Form->control('remplacement_product');
            echo $this->Form->control('title');
            echo $this->Form->control('pcb');
            echo $this->Form->control('prix');
            echo $this->Form->control('uv');
            echo $this->Form->control('poids');
            echo $this->Form->control('volume');
            echo $this->Form->control('dlv');
            echo $this->Form->control('duree_vie');
            echo $this->Form->control('gencod');
            echo $this->Form->control('douanier');
            echo $this->Form->control('dangereux');
            echo $this->Form->control('origin_id', ['options' => $origins]);
            echo $this->Form->control('tva');
            echo $this->Form->control('cdref');
            echo $this->Form->control('category_code');
            echo $this->Form->control('subcategory_code');
            echo $this->Form->control('entrepot');
            echo $this->Form->control('supplier');
            echo $this->Form->control('qualification');
            echo $this->Form->control('couche_palette');
            echo $this->Form->control('colis_palette');
            echo $this->Form->control('pieceartk');
            echo $this->Form->control('ifls_remplacement');
            echo $this->Form->control('assortiment');
            echo $this->Form->control('brand_id', ['options' => $brands]);
            echo $this->Form->control('temperature');
            echo $this->Form->control('active');
            echo $this->Form->control('warnings._ids', ['options' => $warnings]);
            echo $this->Form->control('shortbrands._ids', ['options' => $shortbrands]);
            echo $this->Form->control('shortorigins._ids', ['options' => $shortorigins]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
