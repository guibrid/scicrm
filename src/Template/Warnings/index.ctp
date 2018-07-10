<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Warning[]|\Cake\Collection\CollectionInterface $warnings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Warning'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="warnings index large-9 medium-8 columns content">
    <h3><?= __('Warnings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('field') ?></th>
                <th scope="col"><?= $this->Paginator->sort('value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('urgence') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($warnings as $warning): ?>
            <tr>
                <td><?= $this->Number->format($warning->id) ?></td>
                <td><?= h($warning->title) ?></td>
                <td><?= h($warning->product_code) ?></td>
                <td><?= h($warning->field) ?></td>
                <td><?= h($warning->value) ?></td>
                <td><?= $this->Number->format($warning->urgence) ?></td>
                <td><?= h($warning->created) ?></td>
                <td><?= h($warning->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $warning->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $warning->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $warning->id], ['confirm' => __('Are you sure you want to delete # {0}?', $warning->id)]) ?>
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
