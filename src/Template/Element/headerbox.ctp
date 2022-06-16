<?php
    echo $headertext . "<br/>";

    $this->Html->addCrumb('Fumiko1','/exc-orm/fumiko1');
    $this->Html->addCrumb('Fumiko2','/exc-orm/fumiko2');
    $this->Html->addCrumb('Fumiko3','/exc-orm/fumiko3');
    $this->Html->addCrumb('Fumiko4','/exc-orm/fumiko4');

?>
<?=$this->Html->getCrumbs(' | ',array(
    'text' => 'top',
    'url' => '/exc-orm/index',
    'escape' => false,
    )); ?>