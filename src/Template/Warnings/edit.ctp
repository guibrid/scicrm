<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Warning $warning
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $warning->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $warning->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Warnings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="warnings form large-9 medium-8 columns content">
    <?= $this->Form->create($warning) ?>
    <fieldset>
        <legend><?= __('Edit Warning') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('product_code');
            echo $this->Form->control('field');
            echo $this->Form->control('value');
            echo $this->Form->control('urgence');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
