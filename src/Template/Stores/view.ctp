<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Store $store
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Store'), ['action' => 'edit', $store->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Store'), ['action' => 'delete', $store->id], ['confirm' => __('Are you sure you want to delete # {0}?', $store->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Store'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Substores'), ['controller' => 'Substores', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Substore'), ['controller' => 'Substores', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stores view large-9 medium-8 columns content">
    <h3><?= h($store->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($store->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($store->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($store->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated') ?></th>
            <td><?= h($store->updated) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Substores') ?></h4>
        <?php if (!empty($store->substores)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Store Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($store->substores as $substores): ?>
            <tr>
                <td><?= h($substores->id) ?></td>
                <td><?= h($substores->code) ?></td>
                <td><?= h($substores->title) ?></td>
                <td><?= h($substores->store_id) ?></td>
                <td><?= h($substores->created) ?></td>
                <td><?= h($substores->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Substores', 'action' => 'view', $substores->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Substores', 'action' => 'edit', $substores->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Substores', 'action' => 'delete', $substores->id], ['confirm' => __('Are you sure you want to delete # {0}?', $substores->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
