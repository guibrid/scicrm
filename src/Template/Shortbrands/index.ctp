<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortbrand[]|\Cake\Collection\CollectionInterface $shortbrands
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shortbrands index large-9 medium-8 columns content">
    <h3><?= __('Shortbrands') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('brand_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shortbrands as $shortbrand): ?>
            <tr>
                <td><?= $this->Number->format($shortbrand->id) ?></td>
                <td><?= h($shortbrand->title) ?></td>
                <td><?= $shortbrand->has('brand') ? $this->Html->link($shortbrand->brand->title, ['controller' => 'Brands', 'action' => 'view', $shortbrand->brand->id]) : '' ?></td>
                <td><?= h($shortbrand->created) ?></td>
                <td><?= h($shortbrand->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shortbrand->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shortbrand->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shortbrand->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortbrand->id)]) ?>
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
