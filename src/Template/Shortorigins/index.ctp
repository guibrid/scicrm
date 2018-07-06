<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortorigin[]|\Cake\Collection\CollectionInterface $shortorigins
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shortorigins index large-9 medium-8 columns content">
    <h3><?= __('Shortorigins') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('origin_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shortorigins as $shortorigin): ?>
            <tr>
                <td><?= $this->Number->format($shortorigin->id) ?></td>
                <td><?= h($shortorigin->title) ?></td>
                <td><?= $shortorigin->has('origin') ? $this->Html->link($shortorigin->origin->title, ['controller' => 'Origins', 'action' => 'view', $shortorigin->origin->id]) : '' ?></td>
                <td><?= h($shortorigin->created) ?></td>
                <td><?= h($shortorigin->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shortorigin->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shortorigin->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shortorigin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortorigin->id)]) ?>
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
