<!-- File: src/Template/Articles/view.ctp -->

<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><?= h($article->user_id) ?></p>
<p><small>作成日時: <?= $article->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?></p>
<p><?= $this->Html->link('記事一覧', ['action' => 'index']) ?></p>
