<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Substore[]|\Cake\Collection\CollectionInterface $substores
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Substore'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stores'), ['controller' => 'Stores', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Store'), ['controller' => 'Stores', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="substores index large-9 medium-8 columns content">
    <h3><?= __('Substores') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('store_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($substores as $substore): ?>
            <tr>
                <td><?= $this->Number->format($substore->id) ?></td>
                <td><?= $this->Number->format($substore->code) ?></td>
                <td><?= h($substore->title) ?></td>
                <td><?= $substore->has('store') ? $this->Html->link($substore->store->title, ['controller' => 'Stores', 'action' => 'view', $substore->store->id]) : '' ?></td>
                <td><?= h($substore->created) ?></td>
                <td><?= h($substore->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $substore->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $substore->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $substore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $substore->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
