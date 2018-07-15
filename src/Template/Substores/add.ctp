<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Substore $substore
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Substores'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stores'), ['controller' => 'Stores', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Store'), ['controller' => 'Stores', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="substores form large-9 medium-8 columns content">
    <?= $this->Form->create($substore) ?>
    <fieldset>
        <legend><?= __('Add Substore') ?></legend>
        <?php
            echo $this->Form->control('code');
            echo $this->Form->control('title');
            echo $this->Form->control('store_id', ['options' => $stores]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
