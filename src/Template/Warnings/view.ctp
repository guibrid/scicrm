<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Warning $warning
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Warning'), ['action' => 'edit', $warning->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Warning'), ['action' => 'delete', $warning->id], ['confirm' => __('Are you sure you want to delete # {0}?', $warning->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Warnings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Warning'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="warnings view large-9 medium-8 columns content">
    <h3><?= h($warning->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($warning->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Code') ?></th>
            <td><?= h($warning->product_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Field') ?></th>
            <td><?= h($warning->field) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= h($warning->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($warning->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Urgence') ?></th>
            <td><?= $this->Number->format($warning->urgence) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($warning->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($warning->modified) ?></td>
        </tr>
    </table>
</div>
