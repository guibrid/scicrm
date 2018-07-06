<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Brand $brand
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['controller' => 'Shortbrands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['controller' => 'Shortbrands', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="brands form large-9 medium-8 columns content">
    <?= $this->Form->create($brand) ?>
    <fieldset>
        <legend><?= __('Add Brand') ?></legend>
        <?php
            echo $this->Form->control('title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
