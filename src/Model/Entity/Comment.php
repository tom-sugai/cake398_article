<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
// Collection クラスをインポートします
use Cake\Collection\Collection;

class Comment extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
    
}
?>