<?php $this->assign("title","fumiko1") ?>
<?php $this->assign("h1", "-- fumiko1 --"); ?>
<?php $this->set('headertext', '----- header block'); ?>
<?php $this->set('footertext', '----- footer block'); ?>
<div><?= $this->Flash->render('info') ?></div>
<h2>◆スタイルシートとは</h2>
<p class="text-6">Webページをデザイン・開発するために開発された規格です。</p>
<h3>●スタイルシートの原理</h3>
<p class="text-6">一般的なワープロやDTPソフトが備えている機能に<span>「スタイル」機能</span>があります。</p>
<br/>

<?php 
    $this->Breadcrumbs->add(
        'fumiko2',
        ['controller' => 'exc-orm', 'action' => 'fumiko2']
    );
    $this->Breadcrumbs->add(
        'fumiko3',
        ['controller' => 'exc-orm', 'action' => 'fumiko3']
    );
    $this->Breadcrumbs->add(
        'fumiko4',
        ['controller' => 'exc-orm', 'action' => 'fumiko4']
    );
    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => ' | ']
    );
?>