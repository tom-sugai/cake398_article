<h1>Cookie Sample Page</h1>
<p>set_cookie sample.</p>
<?= $this->Form->create(null,['type' => 'post']); ?>
    <fieldset>
        <?= $this->Form->text("mycookie"); ?>
    </fieldset>
    <?= $this->Form->button("SEND"); ?>
<?= $this->Form->end() ?>