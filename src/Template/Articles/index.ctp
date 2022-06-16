<!-- ページ内メニュー -->
<dev id="index-menu">
    <ul>
        
        <li><?= $this->Html->link('ログイン',['controller' => 'Users','action' => 'login']) ?></li>
        <li><?php echo "login name :" . $loginname; ?></li>
        <li><?= $this->Html->link('ログアウト',['controller' => 'Users','action' => 'logout']) ?></li>
        <li><?= $this->Html->link("投稿", ['action' => 'add']) ?></li>
    </ul>
</dev>

<!-- File: src/Template/Articles/index.ctp  (削除リンク付き) -->
<h4>記事一覧</h4>
<table>
        <tr class="midasi">
            <th>id</th>
            <th>タイトル</th>
            <th>作成日時</th>
            <th>操作</th>
        </tr>
    <!-- ここで、$articles クエリーオブジェクトを繰り返して、記事情報を出力します -->
    <?php foreach ($articles as $article): ?>
        <!-- <?= $article ?> -->
        <tr class="naiyou">
            <td class="col-1"><?= $article->id ?></td>
            <td class="col-1">
                <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
            </td>
            <!-- 
            <td>
                <?= $article->tag_string ?>
            </td>
            -->
            <td class="col-2">
                <?= $article->created->format('Y-m-d') ?>
            </td>
            <td>
                <?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?>
                <?= $this->Form->postLink(
                    '削除',
                    ['action' => 'delete', $article->slug],
                    ['confirm' => 'よろしいですか?']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="paginator">
    <ul class="pagination">
        <?=$this->Paginator->first(' << first ') ?>
        <?=$this->Paginator->prev(' < prev ') ?>
        <?=$this->Paginator->next(' next > ') ?>
        <?=$this->Paginator->last(' last >> ') ?>
    </ul>
</div>