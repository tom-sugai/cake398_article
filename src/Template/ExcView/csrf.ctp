<h1>CSRF Sample Page</h1>
<p>This is sample page.</p>
<?= $this->Form->create(null,['type' => 'post']); ?>
    <fieldset>
        <?= $this->Form->text("name"); ?>
        <?= $this->Form->password("password"); ?>
    </fieldset>
    <?= $this->Form->button("SEND"); ?>
<?= $this->Form->end() ?>