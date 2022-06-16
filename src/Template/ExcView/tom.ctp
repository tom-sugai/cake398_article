<?php
echo "Domain : " . $domain . "<br/>";
echo "Method : " . $method . "<br/>";

if(!empty($params)){
    foreach($params as $param){
        echo $param . "<br/>";
    }
}
?> 
    <?= $this->Form->create(null, ['url' => ['controller' => 'ExcView', 'action' => 'tom'], 'type' => 'post']); ?>
    <?= $this->Form->input('text1'); ?>
    <?= $this->Form->input('text2'); ?>
    <?= $this->Form->input('text3'); ?>
    <?= $this->Form->submit('送信'); ?>
    <?= $this->Form->end(); ?>



<?php
/** 
<form action='tom' method='POST'>
    <input type="text" name="text1" />
    <input type="text" name="text2" />
    <input type="text" name="text3" />
    <input type="submit" value="送信"/>
</form>
*/
?>