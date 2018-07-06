<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortorigin $shortorigin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shortorigins form large-9 medium-8 columns content">
    <?= $this->Form->create($shortorigin) ?>
    <fieldset>
        <legend><?= __('Add Shortorigin') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('origin_id', ['options' => $origins]);
            echo $this->Form->control('products._ids', ['options' => $products]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
