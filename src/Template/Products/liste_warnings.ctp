<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warnings'), ['controller' => 'Warnings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warning'), ['controller' => 'Warnings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['controller' => 'Shortbrands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['controller' => 'Shortbrands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['controller' => 'Shortorigins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['controller' => 'Shortorigins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="products index large-9 medium-8 columns content">
    <h3><?= __('Products') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">code</th>
                <th scope="col">active</th>
                <th scope="col">Warnings</th>
                <th scope="col">Valeur</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= h($product['code']) ?></td>
                <td><?= h($product['active']) ?></td>
                <td><?= h($product['w']['title']) ?></td>
                <td><?= h($product['w']['value']) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $product['id']]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product['id'], $product['code']]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $product['id'])]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
