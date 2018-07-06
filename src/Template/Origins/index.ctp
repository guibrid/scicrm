<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Origin[]|\Cake\Collection\CollectionInterface $origins
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['controller' => 'Shortorigins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['controller' => 'Shortorigins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="origins index large-9 medium-8 columns content">
    <h3><?= __('Origins') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($origins as $origin): ?>
            <tr>
                <td><?= $this->Number->format($origin->id) ?></td>
                <td><?= h($origin->title) ?></td>
                <td><?= h($origin->created) ?></td>
                <td><?= h($origin->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $origin->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $origin->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $origin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $origin->id)]) ?>
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
