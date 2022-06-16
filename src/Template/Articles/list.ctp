count : <?=$count ?><br/>
<div>
    <table>
        <tr>
            <th><?=$this->Paginator->sort('id','id') ?></th>
            <th><?=$this->Paginator->sort('title','title') ?></th>
            <th><?=$this->Paginator->sort('body','body') ?></th>
            <th><?=$this->Paginator->sort('slug','slug') ?></th>
            <th><?=$this->Paginator->sort('published','published') ?></th>
            <th><?=$this->Paginator->sort('created','') ?></th>
            <th><?=$this->Paginator->sort('modified','') ?></th>
 
        </tr>    
        <!--    <?=$this->Html->tableHeaders(['id','title','body','slug','created','published']) ?> -->
        <!-- ここで、$articles クエリーオブジェクトを繰り返して、記事情報を出力します -->
        <?php foreach ($articles as $article): ?>
            <?=$this->Html->tableCells(
            [
                $article->id,
                $article->title,
                $article->body,
                $article->slug,
                $article->published,
                $article->created,
                $article->modified              
            ]) ?>    
        <?php endforeach; ?>
    </table>
</div>
<div class="paginator">
    <ul class="pagination">
        <?=$this->Paginator->numbers([
            'before' => $this->Paginator->hasPrev() ?
                $this->Paginator->first('<<') . '.' : '',
            'after' => $this->Paginator->hasNext() ?
                '.' . $this->Paginator->last('>>') : '',
            'modulus' => 4,
            'separation' => '.'
        ]) ?>
    <!--    <?=$this->Paginator->first(' << first ') ?>
        <?=$this->Paginator->prev(' < prev ') ?>
        <?=$this->Paginator->next(' next > ') ?>
        <?=$this->Paginator->last(' last >> ') ?>
    -->
    </ul>
</div>