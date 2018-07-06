<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortbrand $shortbrand
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shortbrand->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shortbrand->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shortbrands form large-9 medium-8 columns content">
    <?= $this->Form->create($shortbrand) ?>
    <fieldset>
        <legend><?= __('Edit Shortbrand') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('brand_id', ['options' => $brands]);
            echo $this->Form->control('products._ids', ['options' => $products]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
