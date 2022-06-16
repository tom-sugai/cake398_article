<!-- src/Template/Common/fumicom.ctp -->
<?= $this->fetch('content') ?>
<div class="sidebar">
    <?= $this->fetch('sidebar') ?>
</div>
<div class="actions">
    <h3>関連アクション</h3>
    <ul>
    <?php echo $this->Html->link('tom', ['action' => 'tom']) . "<br/>"; ?>
    </ul>
</div>

