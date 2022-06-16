<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class DataArrayComponent extends Component {
    public $name = "DataArray";

    public function getMergedArray($data){
        $arr = [];
        foreach ($data as $obj){
            array_push($arr,$obj->toArray());
            return $arr;
        }
    }
}
?>