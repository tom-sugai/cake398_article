<?php
    echo $headertext . "<br/>";

    $this->Html->addCrumb('Fumiko1','/exc-view/fumiko1');
    $this->Html->addCrumb('Fumiko2','/exc-view/fumiko2');
    $this->Html->addCrumb('Fumiko3','/exc-view/fumiko3');
    $this->Html->addCrumb('Fumiko4','/exc-view/fumiko4');

?>
<?=$this->Html->getCrumbs(' | ',array(
    'text' => 'top',
    'url' => '/exc-orm/index',
    'escape' => false,
    )); ?>