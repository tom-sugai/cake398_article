<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\TableSchema;
use Cake\Database\Schema\Collection;
//use Cake\Collection\Collection;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\CsrfComponent;
use Cake\Utility\Hash;
use Cake\Log\Log;


class ExcOrmController extends AppController{
   
    private $sampleHashList;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        //$this->loadComponent('Csrf');
        $this->Auth->allow(['collectionObj','hash2','hashUtility','introDb','queryBuilder','dataKeep','conn']);
        //基盤となるデータ
        $this->sampleHashList =[
            ["name"=>" kazumi", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
            ["name"=>"ichirou","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
            ["name"=>" yuusuke","domain"=>"hotmail.com", "age"=>"25","pref"=>"chiba"],
            ["name"=>" satoshi","domain"=>"gmail.com", "age"=>"45","pref"=>"kanagawa"],
            ["name"=>"jirou ",  "domain"=>"hotmail.com", "age"=>"9","pref"=>"tokyo"]
        ];

    }

    public function beforeFilter(Event $event)
    {
         //$this->Security->setConfig('unlockedActions', ['tom']);
         //$this->Cookie->config('path', '/');
         //$this->eventManager()->off($this->Csrf);
    }

    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
        //debug($this->response);
    }

    public function index() {
        $this ->autoLayout = true;
        $this->autoRender = true;

        $this->Flash->set('---- Flash test from /index() ----');
        $this->set('msg', 'Welcome to CakePHP3.9 Application.');
    }

    public function fncTest() {

        $this ->autoLayout = true;
        $this->autoRender = false;

        $this->Flash->set('---- Function test from /fncTest() ----');
        $this->set('msg', 'Welcome to CakePHP3.9 Application.');
    }

    public function hash2() {
        $this ->autoLayout = true;
        $this->autoRender = false;
        
        $foo_string = 'aaa,bbb,ccc';
        $foo_array = explode(',', $foo_string);
        var_dump($foo_string) . "<br/>";
        var_dump($foo_array);

    }

    public function hashUtility() {
        $this ->autoLayout = true;
        $this->autoRender = false;

        $data = [
            [
                'id' => 0, 
                'name' => 'akira', 
                'income' => 700,
                'friend' => ['yuta', 'nao', 'hiroki']
            ],
            [
                'id' => 1, 
                'name' => 'tetu', 
                'income' => 100,
                'friend' => ['yui', 'toru', 'hiroki', 'miku', 'tomoya']
            ],
            [
                'id' => 2, 
                'name' => 'syoko', 
                'income' => 1500,
                'friend' => ['akira']
            ]
        ];

           
        // static Cake\Utility\Hash::get(array|ArrayAccess $data, $path, $default = null)
        // 直接的に指定するパス式のみがサポートされます
        // {n} 、 {s} 、 {*} 、または、マッチャーを使ったパスはサポートされません
        /** 
        // 配列から１つの値だけを取り出したい場合に get() を使ってください
        $test_1 = Hash::get($data, '0.id');
        $test_2 = Hash::get($data, '0.name');
        $test_3 = Hash::get($data, '0.income');
        $test_4 = Hash::get($data, '0.friend');      
        debug($test_1);
        debug($test_2);
        debug($test_3);
        debug($test_4);  
        */

        // static Cake\Utility\Hash::extract(array|ArrayAccess $data, $path)
        // Hash パス構文 にあるすべての式とマッチャーを サポートします。
        // extract を使うことで、配列もしくは ArrayAccess インターフェイスを 実装したオブジェクトから
        // 好きなパスに沿ったデータを手早く取り出すことができます
        // データ構造をループする必要はありません。その代わりに欲しい要素を絞り込むパス式を使う
        /** 
        $test_4 = Hash::extract($data, '{n}[id=1].name');
        $test_5 = Hash::extract($data, '{n}.friend');
        $test_6 = Hash::extract($data, '{n}.{s}');
        $test_7 = Hash::extract($data, '{*}');
        $test_8 = Hash::extract($data, '0.friend.2');
        debug($test_4);
        //debug($test_5);
        //debug($test_6);
        //debug($test_7);
        debug($test_8);
        */ 
    
        // static Cake\Utility\Hash::insert(array $data, $path, $values = null)
        // $values を $path の定義に従って配列の中に挿入します
        //$result = Hash::insert($data, '0.friend.3', 'yuki');
        //debug($result);
        //$result = Hash::insert($data, '2.dislike', 'yuki');
        //debug($result);
        //$result = Hash::insert($data, '{n}.dislike', ['yuki', 'shinta']);
        //debug($result);
    
        //Hash::remove()
        //debug($data);
        //$result = Hash::remove($data, '{n}.friend.4');
        //$result = Hash::remove($data, '{n}[id=1]');
        //$result = Hash::remove($data, '{n}[]');
        //$result = Hash::remove($data, '{n}.income');
        //$result = Hash::remove($data, '{n}.friend.4');
        //debug($result);

        $data2 = 
        [
            [
                'User' => [
                    'id' => 2,
                    'group_id' => 1,
                    'Data' => [
                        'user' => 'mariano.iglesias',
                        'name' => 'Mariano Iglesias'
                    ]
                ]
            ],
            [
                'User' => [
                    'id' => 14,
                    'group_id' => 2,
                    'Data' => [
                        'user' => 'phpnut',
                        'name' => 'Larry E. Masters'
                    ]
                ]   
            ]
        ];
        debug($data2);
        
        $result = Hash::combine($data2, '1.User.id');
        $result = Hash::combine($data2, '{n}.User.id', '{n}.User.Data.user');
        $result = Hash::combine($data2, '{n}.User.id', '{n}.User.Data.name');
        $result = Hash::combine($data2, '{n}.User.id');
        $result = Hash::combine($data2, '{n}.User.id', '{n}.User.Data');
        $result = Hash::combine($data2, '{n}.User.id', '{n}.User.Data', '{n}.User.group_id');
        debug($result);
        debug($result[2][14]['user']);
    }

    public function collectionObject() {
        $this ->autoLayout = true;
        $this->autoRender = false;
        echo "xxxxxxxxxxxxxx";

        /** 
        // 応用編
        //基盤となるデータ
        $sampleHashList =[
                ["name"=>" kazumi", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
                ["name"=>"ichirou","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
                ["name"=>" yuusuke","domain"=>"hotmail.com", "age"=>"25","pref"=>"chiba"],
                ["name"=>" satoshi","domain"=>"gmail.com", "age"=>"45","pref"=>"kanagawa"],
                ["name"=>"jirou ",  "domain"=>"hotmail.com", "age"=>"9","pref"=>"tokyo"]
        ];
        //条件に合致するものをセレクトして配列に
    
        $hoge = ( collection( $sampleHashList ))->filter( function ( $person, $index ){
            return ( $person['age'] > 8 && $person['pref'] === 'tokyo' );
        })->toArray();
        echo "<pre>";
        var_dump($hoge);
        echo "</pre>";
        */
        /** 
        //条件に合わないもの(下記例だと東京以外）を抽出してeach
     
        $hoge = ( collection( $this->sampleHashList ))->reject( function ( $person, $index ){
            return ( $person['pref'] === 'tokyo' );
        })->each(function ( $person ,$index){
            echo "<pre>";
            var_dump( $index );
            echo "</pre>";
            //echo "<pre>";
            //var_dump( $person );
            //echo "</pre>";
        });
        */
        /** 
        // reject & each---条件に合う配列を取り出して特定プロパティ(この場合はname)のみ出力してeach
    
        $hoge = ( collection( $this->sampleHashList ))->reject( function ( $person, $index ){
            return ( $person['pref'] === 'tokyo' );
        })->extract('name')->each(function ( $person ,$index){
            echo "<pre>";
            var_dump( $index );
            echo "</pre>";
            echo "<pre>";
            var_dump( $person );
            echo "</pre>";
            echo "--------";
        });
        */
        /**
        //特定キーでグルーピング
     
        $hoge = ( collection( $this->sampleHashList ))->groupBy('pref')
        ->each(function ( $person ,$index){
            echo "<pre>";
            var_dump( $index );
            echo "</pre>";
            echo "<pre>";
            var_dump( $person );
            echo "</pre>";
            echo "--------";
        });
        */
        /**
        //20才以上などの条件でグルーピング
     
        $hoge = ( collection( $this->sampleHashList ))->groupBy(function ( $person ){
            return $person['age'] >= 30;
        })->each(function ( $person ,$index){
            echo "<pre>";
            var_dump( $index );
            echo "</pre>";
            echo "<pre>";
            var_dump( $person );
            echo "</pre>";
            echo "--------";
        });
        */
        /**
        // 集合　map combine reject
    
        //内部で別の変数を作りリターン----それによるグルーピング 
        $hoge = ( collection( $this->sampleHashList ))->map(function ( $person ,$index){
            $person['devideKey'] = $person['domain'] .'_' . $person['pref'];
            return $person;
        })->groupBy('devideKey')->toArray();
        echo "<pre>";
        var_dump($hoge);
        echo "</pre>";
        echo "1 --------";

        //なんらかのプロパティをキーにする(通常は code や id が多い)
        $hoge = ( collection( $this->sampleHashList ))->combine('name','domain')->toArray();
        echo "<pre>";
        var_dump($hoge);
        echo "</pre>";
        echo "2--------";

        //なんらかのプロパティをキーにして、配列はそのまま使う
        $hoge = ( collection( $this->sampleHashList ))->combine('name', function( $person) { return $person;} )->toArray();
        echo "<pre>";
        var_dump($hoge);
        echo "</pre>";
        echo "3--------";

        //差分の出力
        $preCustomerItemsIds = [1,2,3,4];
        $postCustomerItemsIds = [2,4,5];
        //useは外部の変数を使いたい場合、スコープの拡張に使います。
        $deleteIds = ( collection($preCustomerItemsIds))->reject(function ($id) use ( $postCustomerItemsIds ){
            return in_array( $id, $postCustomerItemsIds, true );
        })->toArray();
        echo "<pre>";
        var_dump($deleteIds);
        echo "</pre>";
        echo "4 --------";
        */

        /** 
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        //debug($items);
        // $collection = new Collection($items);
        // collection() ヘルパー関数
        // ヘルパーメソッドの利点は、 (new Collection($items)) よりも連鎖が容易である
        $collection = collection($items);
        //debug($collection);

        echo "\$items" . "<br/>";
        echo "items['a'] = " . $items['a'] . "<br/>";
        echo "items['b'] = " . $items['b'] . "<br/>";
        echo "items['c'] = " . $items['c'] . "<br/>";
        echo "<br/>";
        */

        /** 
        print_r($items);

        echo "<pre>";
        var_dump($items);
        echo "</pre>";

        var_export($items);

        echo "<br/>";
        foreach($items as $key => $value){
            echo "要素 $key: $value" . "<br/>";     
        };

        echo "<br/>";

        $collection =$collection->each(function($value, $key){
            echo "要素 $key: $value" . "<br/>";       
        });
        */
    
        /**
        // each()メソッド
        // each() の戻り値はコレクションオブジェクトです
        // 即時にコレクション内の各値にコールバックを 適用する反復処理します
        $collection = $collection->each(function ($value, $key) {
            if($key == "a") {
                $value = 10;
                echo "要素 $key: $value" . "<br/>";     
            }
            if($key == "b") {
                $value = 20;
                echo "要素 $key: $value" . "<br/>";
            }
            if($key == "c") {
                $value = 30;
                echo "要素 $key: $value" . "<br/>";
            }
            echo "-----------" . "<br/>";
            
        });
        */
        /**
        // map()メソッドは、元のコレクション内の各オブジェクトに適用されるコールバックの出力に基づいて
        // 新しいコレクションを作成する、適用されるコールバックの出力 -> return $value * 2;
        $new = $collection->map(function ($value, $key) {
            return $value * 2;
        });
        $result = $new->each(function ($value, $key) {
            echo "要素 $key: $value" . "<br/>";
        });    
        
        $result = $new->toList();
        // $result には [2, 4, 6] が含まれています。
        debug($result);
        echo $result[0] . "<br/>";
        echo $result[1] . "<br/>";
        echo $result[2] . "<br/>";
        
        $result = $new->toArray();
        // $result には ['a' => 2, 'b' => 4, 'c' => 6] が含まれています。
        debug($result);
        echo $result['a'] . "<br/>";
        echo $result['b'] . "<br/>";
        echo $result['c'] . "<br/>";

        // map() 関数の最も一般的な用途の1つはコレクションから単一の列(list)を抽出すること
        // toList  --> [2, 4, 6]
        // toArray --> ['a' => 2, 'b' => 4, 'c' => 6]
        */
    
        /** 
        // extract($matcher)
        // 特定のプロパティーの値を含む要素のリストを構築したい場合は、 extract()
        
        $pepole = [
            ['name' => 'mark',    'profile' =>  ['age' => 20, 'city' =>'tokyo'], 'phone' => '100-1000'],
            ['name' => 'jose',    'profile' =>  ['age' => 30, 'city' =>'nagoya'],'phone' => '200-2000'],
            ['name' => 'barbara', 'profile' =>  ['age' => 40, 'city' =>'osaka'], 'phone' => '300-3000']
        ];
        debug($pepole);
        $collection = collection($pepole);
        $items = $collection->extract('profile.age');
        $items = $items->each(function($value, $key){
            echo "要素 $key : $value" . "<br/>";
        });
        echo "<br/>";

        // $result には  ['mark', 'jose', 'barbara'] が含まれています。
        $results = $items->toList();
        foreach ($results as $item) {
            echo $item . "<br/>";
        }
        */

        /** 
        // パスのキーに {*} マッチャを 使用する
        // マッチャは、 HasMany や BelongsToMany の関連データを照合する時に 便利です
        $data = [
            [
                'name' => 'James',
                'phone_numbers' => [
                    ['number' => 'number-1'],
                    ['number' => 'number-2'],
                    ['number' => 'number-3'],
                ],
                'capacities' => [
                    ['capacity' => 'it-1'],
                    ['capacity' => 'it-2'],
                    ['capacity' => 'it-3']
                ]
            ],
            [
                'name' => 'James',
                'phone_numbers' => [
                    ['number' => 'number-4'],
                    ['number' => 'number-5'],
                ],
                'capacities' => [
                    ['capacity' => 'it-4'],
                    ['capacity' => 'it-5'],
                    ['capacity' => 'it-6']
                ]
            ]
        ];
        // Hash::extract() とは異なり、このメソッドは {*} ワイルドカードのみをサポートしています
        $numbers = (collection($data))->extract('capacities.{*}.capacity');
        // toList() メソッドを 使用することにより、重複するキーが存在する場合でも、すべての値を取得することが保証されます
        $results = $numbers->toList();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        */
        /** 
        // Cake\Collection\Collection::combine($keyPath, $valuePath, $groupPath = null)
        // 既存のコレクションの中のキーと値から作られた新しいコレクションを作成することができます。
        // キーと値の両方のパスは、ドット記法のパスで指定することができます。
        $items = [
            ['id' => 1, 'name' => 'foo', 'parent' => 'a'],
            ['id' => 2, 'name' => 'bar', 'parent' => 'b'],
            ['id' => 3, 'name' => 'baz', 'parent' => 'a'],
        ];
        $combined = (collection($items))->combine('id', 'name');
        $results = $combined->toArray();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        // $groupPath = 'pearent' を指定した
        $combined = (collection($items))->combine('id', 'name', 'parent');
        $results = $combined->toArray();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        
        // 未完成　----　$articles->find()に変更する(クエリーはコレクション)
        // コレクションの引数は配列かTraversableのみ可
        // 動的にキーと値とグループのパスを構築するために クロージャー を使用することができます
        // 例えば、エンティティーや(ORM によって Cake/Time インスタンスに変換された) 日付で作業する場合、
        // 日付で結果をグループ化するのによいでしょう。
        // **** ここにテーブルレジストリの記述が必要 ------
        $combined = (collection($articles->find()))->combine(
            'id',
            function ($article) { return $article; },
            function ($article) { return $article->created->toDateString(); }
        );
        */ 
        /**
        //Collection::stopWhen(callable $c)
        // 任意の時点で反復を停止することができます
        // コレクションの中でこのメソッドを呼び出すと、新しいコレクションを作成し、
        // 要素のいずれかで、 渡された callable が false を返した場合、結果の引き渡しを停止します
        $items = [10, 20, 50, 1, 2];
        $collection = collection($items);
        $new = $collection->stopWhen(function ($value, $key) {
            // 30 より大きい最初の値で停止します。//条件が成立するとfalseを返す
            return $value < 2;
        });

        // $results には [10, 20] が含まれています。
        $results = $new->toList();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        */

        /** 
        // Collection::unfold(callable $c)
        // コレクション内の要素に、複数の要素を持つ配列やイテレータが含まれています。 
        // すべての要素に対して一回の反復で済むように内部構造を平坦化したい場合は、 unfold() メソッドが使用できます
        // コレクション内のネストされた すべての単一の要素をもたらす新しいコレクションを作成します
        $items = [[1, 2, 3], [4, 5]];
        $collection = collection($items);
        $new = $collection->unfold();
        // $result には [1, 2, 3, 4, 5] が含まれています。
        $results = $new->toList();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        // PHP 5.5 以降を使用している場合は、
        // コレクション内の各アイテムを必要なだけ 複数の要素として返すために
        // unfold() の中で yield キーワードを使用することができます。
        $oddNumbers = [1, 3, 5, 7];
        $collection = collection($oddNumbers);
        $new = $collection->unfold(function ($oddNumber) {
            yield $oddNumber;
            yield $oddNumber + 1;
        });
        // $result には [1, 2, 3, 4, 5, 6, 7, 8] が含まれています。
        $results = $new->toList();
        echo "<pre>";
        var_dump($results);
        echo "</pre>";
        */

        /** 
        // Collection::chunk($chunkSize)
        // コレクションをある程度の大きさの複数の配列に分割するために、 chunk() 関数を使用する 
        $items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        $collection = collection($items);
        $chunked = $collection->chunk(2);
        $results = $chunked->toList(); // [[1, 2], [3, 4], [5, 6], [7, 8], [9, 10], [11]]
        echo "<pre>";
        var_dump($results);
        echo "</pre>";

        // 未完成----テーブル定義が未設定
        // chunk 関数は、例えばデータベースの結果のために、バッチ処理を行う場合、 特に便利です。
        $collection = new Collection($articles);
        $collection->map(function ($article) {
                // article のプロパティーを変更します。
                $article->property = 'changed';
            })
            ->chunk(20)
            ->each(function ($batch) {
                myBulkSave($batch); // この関数は、バッチごとに呼び出されます。
            });
        */
        /** 
        // Collection::chunkWithKeys($chunkSize)
        // chunkWithKeys() は、コレクションを小さい塊に薄切りにしますが、 キーは保持されます
        // これは、連想配列を分割するのに便利です
        $collection = collection([
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => [4, 5]
        ]);
        $chunked = $collection->chunkWithKeys(2)->toList();
        echo "<pre>";
        var_dump($chunked);
        echo "</pre>";
        // 作成物
        // [
        //    ['a' => 1, 'b' => 2],
        //    ['c' => 3, 'd' => [4, 5]]
        // ]
        */
        /**
        // Collection::filter(callable $c)
        // コールバックに一致する要素の新しいコレクションを作成するには、 filter() を使用することができます
         
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = Collection($items);
        // １より大きい要素を含む  // 新しいコレクションを作成
        $overOne = $collection->filter(function ($value, $key) {
            return $value > 0;
        });
        $overOne = $overOne->each(function($value, $key){
            echo "要素 $key : $value" . "<br/>";
        });
        */
        /**
        $pepole = [
            'a' => ['name' => 'mark', 'gender' => 'male', 'age' => 20],
            'a' => ['name' => 'jose', 'gender' => 'male', 'age' => 30],
            'a' => ['name' => 'barbara', 'gender' => 'female', 'age' => 40]
        ];
        $collection = collection($pepole);
        debug($collection);

        $ladies = $collection->filter(function($person, $key){
            return $person['gender'] === 'female';
        });
        $result = $ladies->toList();
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
        $guys = $collection->reject(function ($person, $key){
            return $person['gender'] === 'female';
        });
        $result = $guys->toList();
        echo "<pre>";
        var_dump($result);
        echo "</pre>";

        // Collection::every(callable $c)
        // コレクション内のすべての要素が条件を 満たしているかどうかを確認するにはevery() が使用できます
        $allYoungPeople = $collection->every(function ($person) {
            return $person['age'] > 19;
        });
        echo "<pre>";
        var_dump($allYoungPeople);
        echo "</pre>";

        // Collection::some(callable $c)
        // 合致する要素が、コレクションに少なくとも１つ含まれているかどうかを確認する
        $hasYoungPeople = $collection->some(function ($person) {
            return $person['age'] < 21;
        }); 
        echo "<pre>";
        var_dump($hasYoungPeople);
        echo "</pre>";
         */

        /** 
        $pepole = [
            ['person' => ['name' => 'mark', 'gender' => 'male', 'age' => 20]],
            ['person' => ['name' => 'jose', 'gender' => 'male', 'age' => 30]],
            ['person' => ['name' => 'barbara', 'gender' => 'female', 'age' => 40]],
        ];
        $average = collection($pepole)->avg('person.age');
        echo "average : $average";

        // Collection::match(array $conditions)
        // 指定したプロパティーを持つ要素のみを含んだ新しいコレクションを抽出する
        //debug($collection);
        $commentsFromMark = collection($pepole)->match(['person.name' => 'mark'])->toList();
        echo "<pre>";
        var_dump($commentsFromMark);
        echo "</pre>";
     
        // Collection::firstMatch(array $conditions)
        // プロパティー名は、ドット区切りのパスになります。
        // ネストされたエンティティーを横断し、 それらに含まれる値を一致させることができます
        // コレクションから、最初に一致した要素が必要な場合、 firstMatch() を使用する
        $collection = collection($pepole);
        $comment = $collection->firstMatch([
            'person.gender' => 'male',
            'person.age' => 30,
        ]);
        echo "<pre>";
        var_dump($comment);
        echo "</pre>";
        

        // 集約

        // Collection::reduce(callable $c)
        // コレクション内のすべての要素から１つの結果を得る

        // Collection::min(string|callable $callback, $type = SORT_NUMERIC)
        // コレクションの最小値を抽出するには、 min() 関数を使用

        // Collection::max(string|callable $callback, $type = SORT_NUMERIC)
        // コレクションから最も高いプロパティー値を持つ要素を返します

        // Collection::sumOf(string|callable $callback)
        // sumOf() メソッドは、すべての要素のプロパティーの合計を返します

        // Collection::avg($matcher = null)
        // コレクション内の要素の平均値を計算します
        $items = [
        ['invoice' => ['total' => 100]],
        ['invoice' => ['total' => 200]],
        ];
        // 平均値: 150
        $average = (collection($items))->avg('invoice.total');
        echo "average : $average" ."<br/>";

        // Collection::median($matcher = null)
        // 要素の集合の中央値を計算します
        */
        /** 
        // グループ化とカウント
        // Collection::groupBy($callback)
        // コレクションの要素がプロパティーに同じ値を持つ場合、キー別にグループ化した 新しいコレクションを作る
        $students = [
            ['name' => 'Mark', 'grade' => 9],
            ['name' => 'Andrew', 'grade' => 10],
            ['name' => 'Stacy', 'grade' => 10],
            ['name' => 'Barbara', 'grade' => 9]
        ];
        $collection = collection($students);
        $studentsByGrade = $collection->groupBy('grade')->toArray();
        echo "<pre>";
        var_dump($studentsByGrade);
        echo "</pre>";
        // 動的にグループを生成するために、ネストされたプロパティーのドットで区切られたパス 
        // または独自のコールバック関数のいずれかを指定することができます
        //$commentsByUserId = $comments->groupBy('name');
        $classResults = $collection->groupBy(function ($student) {
            return $student['grade'] > 6 ? 'approved' : 'denied';
        })->toList();
        print_r($classResults);

        // Collection::countBy($callback)
        // グループごとの出現数を知りたい場合は、 countBy() メソッドを使用して行う

        // Collection::indexBy($callback)
        // グループごとに単一の結果が欲しいなら、 indexBy() 関数を使用する

        // Collection::zip($elements)
        // 異なるコレクションの要素をグループ化することができます
        // zip() メソッドは、多次元配列を転置するのに非常に便利です
 

        // ソート
        // Collection::sortBy($callback)
        // コレクションの値は、カラムまたはカスタム関数に基づいて昇順または降順でソートすることができます

        // ツリーデータの操作
        // コレクションは、簡単に階層またはネストされた構造を、構築したり平坦化することができます
        // 親の識別子プロパティーによって子がグループ化されるような、ネストされた構造を作成するには、
        //  nest() メソッドが簡単です
        // Collection::nest($idPath, $parentPath)
        // この関数には、２つのパラメーターが必要です。 １つ目は、項目の識別子を表すプロパティーです。
        // ２つ目のパラメーターは、親項目の識別子を表すプロパティーの名前です
        $collection = collection([
            ['id' => 1, 'parent_id' => null, 'name' => 'Birds'],
            ['id' => 2, 'parent_id' => 1, 'name' => 'Land Birds'],
            ['id' => 3, 'parent_id' => 1, 'name' => 'Eagle'],
            ['id' => 4, 'parent_id' => 1, 'name' => 'Seagull'],
            ['id' => 5, 'parent_id' => 6, 'name' => 'Clown Fish'],
            ['id' => 6, 'parent_id' => null, 'name' => 'Fish'],
        ]);
        //$results = $collection->nest('id', 'parent_id')->toList();
        //echo "<pre>"; echo var_dump($results); echo "</pre>";
        // Collection::listNested($dir = 'desc', $nestingKey = 'children')
        // nest() の逆の関数は listNested() です。このメソッドは、ツリー構造を線形構造に 戻すように平坦にすることができます
        $results1 = $collection->nest('id', 'parent_id');
        $results2 = $results1->listNested()->toList();
        echo "<pre>"; echo var_dump($results2); echo "</pre>";

        // その他のメソッド

        // Collection::isEmpty()
        // コレクションに要素が含まれているかどうかを確認する

        // Collection::contains($value)
        // コレクションは、 contains() メソッドを使用して、ある特定の値が含まれているかどうかを、確認することができます
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = collection($items);
        $hasThree = $collection->contains(3);

        // Collection::shuffle()
        // ランダムな位置にそれぞれの値を返す新しいコレクションを作成する

        // Collection::transpose()
        // コレクションを transpose (行列の転置) すると、
        // 元の列のそれぞれで作られた行を含む 新しいコレクションを取得します
        $items = [
            ['Products', '2012', '2013', '2014'],
            ['Product A', '200', '100', '50'],
            ['Product B', '300', '200', '100'],
            ['Product C', '400', '300', '200'],
         ]
         $transpose = (collection($items))->transpose()->toList();
        
         */
        /** 
        // 要素の取り出し
        // Collection::sample(int $size)
        // Collection::sample(int $size)
        // Collection::take(int $size, int $from)
        // Collection::skip(int $positions)
        // Collection::first()
        // Collection::last()

        // コレクションの拡張
        // Collection::append(array|Traversable $items)
        // Collection::appendItem($value, $key)
        // Collection::prepend(array|Traversable $items)
        // Collection::prependItem($value, $key)

        // 要素の更新
        // Collection::insert(string $path, array|Traversable $items)
        // ２つの別々のデータの集合があり、一方の集合の要素を、 他方のそれぞれの要素に挿入したい
        // もともとデータのマージや結合を サポートしないデータソースからデータを取得する際に非常に一般的なケースです

        // コレクションメソッドの再利用
        // Collection::through(callable $c)
        
        //  コレクションの最適化
        // Collection::buffered()

        // 巻き戻し可能なコレクションの作成

        // コレクションの複製
        // Collection::compile(bool $preserveKeys = true)
        */
    }   

    public function introdb() {
        $this ->autoLayout = true;
        $this->autoRender = true;

        //$this->Flash->set('---- Flash test from /introdb() ----');
        $this->set('msg', ' Introduction to CakePHP database access layer ');

        //　クイックツアー
        /** 
        // データーベースの利用－１　--- default データーベースを使い 直接テーブルインスタンスを取得する
        // コネクションオブジェクトの作成とアクセス（省略できる）
        // $connection = ConnectionManager::get('default'); 
        // ArticlesTable のインスタンス取得
        $articles = TableRegistry::getTableLocator()->get('Articles');
        $query = $articles->find();
        $this->set('results', $query);
        */

        // コネクションの管理（ConnectionManager） --- 実行時にDBを指定する
        // defaul('cake_cms')DB以外の、('sampledb')DBとのコネクションを作成する
        // データベース接続を作る(DSN 文字列を使う)
        $dsn = 'mysql://tom:ts0521ts@localhost/sampledb';
        // コネクションオブジェクトの作成
        ConnectionManager::config('sample', ['url' => $dsn]);
        // コネクションオブジェクトにアクセス
        $connection = ConnectionManager::get('sample');
        // 通常はCakeアプリケーションで設定した ’default’ を使う

        // データベースの作成
        // もし、データベースを選択せずに接続したい場合、データベース名を省略してください。
        //$dsn = 'mysql://root:password@localhost/';
        // これでデータベースの作成や変更のクエリーを実行するためにコネクションオブジェクトが使えます。
        //$connection->query("CREATE DATABASE IF NOT EXISTS my_database");

        // データベースの生のSQLを直接実行する
        // select文の実行
        //（'sampledb'）内の('posts')テーブルを検索する
        /** 
        $results = $connection
            ->execute('SELECT * FROM posts')
            ->fetchAll('assoc');
        debug($results);
        $this->set('results',$results);
        */
        // insert
        /** 
        $connection->insert('posts', [
            'title' => 'A New Post',
            'body' => 'A New Post body',
            'user_id' => 4,
            'created' => new \DateTime('now')
        ], ['created' => 'datetime']);
        */
        // update
        /**
        for ($n = 13;$n <= 18; $n++){
            //$n = 13;
            $connection->update('posts', ['title' => 'Updated title'], ['id' => $n]);
        }
         */
        // delete
        /** 
        for ($n = 11;$n <= 12; $n++){
            //$n = 13;
            $connection->delete('posts', ['id' => $n]);
        }
        */

        // Connection クラス(Cake\Database\Connection)
        // データベースコネクションと対話するための シンプルなインターフェイスを提供します。 
        // これはドライバー層への基底インターフェイスであり、
        // クエリーの実行、クエリーのロギング、 トランザクション処理といった機能を提供するためのものです

        // queryメソッドを使う--Connection::query($sql)
        // CakePHP のデータベース抽象化レイヤは、PDO とネイティブドライバー上にラッパー機能を提供します。
        // これらのラッパーは PDO と似たようなインターフェイスを提供します
        /** 
        //ステートメントを作成
        $stmt = $connection->query('SELECT * FROM posts');
        // ステートメントを実行
        $stmt->execute();
        // 結果を取り出す---------
        // １行読み込む-----
        //$results = $stmt->fetch('assoc');
        // 全行を読み込む----
        $results = $stmt->fetchAll('assoc');
        $this->set('results', $results);
        */
        // プレースホルダーを使う
        // もし追加パラメーターが必要ならexecute() メソッドを使用します
        // Connection::execute($sql, $params, $types)
        // execute は指定された値でバインドして SQL ステートメントを直接実行します
        /** 
        $stmt = $connection->execute(
            'SELECT * FROM posts WHERE user_id = ?',
            [2]
        );
        */
        /** 
        // execute は全てのプレースホルダーを文字列とみなします
        // もし特定の型にバインドする必要があるなら、クエリーを生成する時に型名を指定することが できます
        $stmt = $connection
            ->execute('SELECT * FROM posts WHERE user_id = :user_id', 
            ['user_id' => 2],['user_id' => 'integer']);

        $results = $stmt->fetchAll('assoc');
        $this->set('results', $results);
        */

        /** 
        // クエリービルダーを使う----Cake\Database\Connection::newQuery()
        // この方法では、プラットフォーム固有の SQL を使用することなく、複雑で表現力豊かなクエリーを 構築することができます
        $user_id = 2; // fumiko : 2 tom : 3 junji : 4
        $query = $connection
            ->newQuery()
            ->select('*')
            ->from('posts')
            ->where(['user_id =' => $user_id], ['user_id' => 'integer'])
            ->order(['id' => 'ASC']);

        $stmt = $query->execute();
        //$results = $query->execute()->fetchAll('assoc');
        $this->set('results', $stmt);
        //$this->set('results', $results);
        */

        // トランザクションを使う
        /**
        // トランザクション操作の最も基本的な方法は、SQL構文と同じような begin() , commit() , rollback() を使用するものです。
        $conn->begin();
        $conn->execute('UPDATE articles SET published = ? WHERE id = ?', [true, 2]);
        $conn->execute('UPDATE articles SET published = ? WHERE id = ?', [false, 4]);
        $conn->commit();
        // このコネクションインスタンスへのインターフェースに加えて、さらに begin/commit/rollback を 簡単にハンドリングする
        // transactional() メソッドが提供されています
        $conn->transactional(function ($conn) {
            $conn->execute('UPDATE articles SET published = ? WHERE id = ?', [true, 2]);
            $conn->execute('UPDATE articles SET published = ? WHERE id = ?', [false, 4]);
        });
         */

        // ステートメントとの対話
        // ステートメントオブジェクトで、ドライバーから基になるプリペアードステートメントを操作できるように なります
        // ステートメントを準備する // execute() か prepare() でステートメントオブジェクトを生成できます
        // execute() メソッドは引き継いだ値をバインドしたステートメントを返します
        $stmt = $connection->execute(
            'SELECT * FROM posts WHERE user_id = ?',
            [2]
        );
        // prepare はプレースホルダーのための準備をします // 実行する前にパラメーターをバインドする必要があります。
        // 項目の位置で指定
        $stmt = $connection->prepare('SELECT * FROM posts WHERE user_id = ?');
        $stmt->bind([4],['integer']); // bind([値],[型])
        // 項目の通し番号で指定
        $stmt = $connection->prepare('SELECT * FROM posts WHERE user_id = ?');
        $stmt->bindValue(1, 3, 'integer'); // bindValue(番号,値,型)
        // 配列の項目名をキーに指定
        $stmt = $connection->prepare('SELECT * FROM posts WHERE user_id = :user_id');
        $stmt->bind(['user_id' => 2],['integer']);
        
        // 結果を取り出す
        $stmt->execute();
        //$results = $stmt->fetch('assoc');         // 1行読み込む
        $results = $stmt->fetchAll('assoc');    // 全行読み込む
        $this->set('results',$results);

        // 行数を取得する
        $rowCount = count($stmt);
        //$rowCount = $stmt->rowCount();
        $this->set('rowCount',$rowCount);

        // エラーコードをチェックする
        $code = $stmt->errorCode();
        //debug($code);
        $info = $stmt->errorInfo();
        //debug($info);
        $this->set('code',$code);
        $this->set('info',$info);

        // クエリーロギング ---- Cake\Log\Log にクエリーをログ出力
        // クエリーログを有効
        $connection->logQueries(true);
        // クエリーログを停止
        //$connection->logQueries(false);

        // クエリーログを有効にしていると、 'debug' レベルで 'queriesLog' スコープで
        // Cake\Log\Log にクエリーをログ出力します
        // レベル・スコープを出力するようにログ設定をする必要があります

        // Console logging
        /** 
        Log::config('queries', [
            'className' => 'Console',
            'stream' => 'php://stderr',
            'scopes' => ['queriesLog']
        ]);
        */

        /** 
        // File logging
        Log::config('queries', [
            'className' => 'File',
            'path' => LOGS,
            'file' => 'queries.log',
            'scopes' => ['queriesLog']
        ]);
        */


    }
    
    // class /Cake/ORM/Query
    public function queryBuilder() {
        $this->autoLayout = true;
        $this->autoRender = false;

        
        // テーブルオブジェクトを取得
        $articles = TableRegistry::getTableLocator()->get('Articles');
        $tags = TableRegistry::getTableLocator()->get('Tags');
        $users = TableRegistry::getTableLocator()->get('Users');
        //debug($articles);
        /** 
        // ArticlesControllerの中では、$this->Articles->find()でクエリーを取得できる
        // ここでは、テーブルオブジェクトからクエリーを取得
        //$query = $articles->find();
        // 上の２行を１行にまとめると
        //$query = TableRegistry::getTableLocator()->get('Articles')->find();
        // Query オブジェクトのほとんどのメソッドが自分自身のクエリーオブジェクトを返します
        // これは Query が遅延評価される(lazy)ことを意味し、必要になるまで実行されないことを 意味します
        // クエリービルダーを使う----$articles はテーブルオブジェクト
        $query = $articles
            ->find()
            ->select(['id', 'title'])
            ->where(['id !=' => 1])
            ->order(['created' => 'DESC']);
        //debug($query);
        //debug($articles->find()->where(['id !=' => 1])); // SQLを出力する
        // foreach でクエリーが実行される --
        foreach ($query as $article) {
            echo $article->id . ":" . $article->title . "<br/>";
        }
        */
        /** 
        // foreach を使わずに、クエリーを直接実行する
        // all() メソッドか toList() メソッドのどちらかを呼ぶ
        // $resultsIteratorObject は Cake\ORM\ResultSet のインスタンス
        $resultsIteratorObject = $articles
            ->find()
            ->where(['id >' => 1])
            ->all();
        foreach ($resultsIteratorObject as $article) {
            //debug($article->id);
            echo $article->id . ":" . $article->title . "<br/>";
        }
        */
        /** 
        // $resultsArrayは、object(App\Model\Entity\Article) の配列
        $resultsArray = $articles
            ->find()
            ->where(['id >' => 1])
            ->toList();
        //debug($resultsArray);
        // 配列からオブジェクトを取得
        foreach ($resultsArray as $article) { 
            //debug($article->id);
            echo $article->id . ":" . $article->title . "<br/>";
        }
        echo $resultsArray[0]->id . ", ";    
        echo $resultsArray[1]->id . ", ";
        echo $resultsArray[2]->id . ", ";
        echo $resultsArray[3]->id . ", ";
        echo $resultsArray[4]->id . ", ";
        echo $resultsArray[5]->id . ", ";
        echo $resultsArray[6]->id . ", ";
        echo $resultsArray[7]->id;
        */ 
        /**  
        // テーブルから単一行を取得する --- first() メソッドを使う
        $article = $articles
            ->find()
            ->where(['id' => 15])
            ->first();
        debug($article->title);
        

        // カラムから値リストを取得する --- Collection ライブラリーの extract() メソッドを使う
        // これもクエリーを実行します
        echo " --- Articles title list ---" . "<br/>";
        $allTitles = $articles->find()->extract('title');
        debug($allTitles);
        foreach ($allTitles as $title) {
            echo $title . ", ";
        }
        echo "<br/>";
       
        // クエリーの結果から key-value リストを得ることもできます
        $list = $articles->find('list');

        foreach ($list as $id => $title) {
            echo "$id : $title" . "<br/>";
        }
         
        echo " --- Articles slug list ---" . "<br/>";
        $allSlugs = $articles->find()->extract('slug');
        //debug($allSlugs);
        foreach ($allSlugs as $slug) {
            echo $slug . ", " . "<br/>";
        }
        */
        /** 
        echo " --- Tags tag list ---" . "<br/>";
        $allTags = $tags->find()->extract('title');
        foreach ($allTags as $title) {
            echo $title . ", ";
        }
        echo "<br/>";
         
        // クエリーの結果から key-value リストを得る
        $list = $articles->find('list');
        //debug($list);
        foreach ($list as $id => $title) {
            echo "$id : $title" . "<br/>";
        }
        */        
        /** 
        // クエリーはクエリーを返す　//クエリーは Collection オブジェクトである
        // / Collection ライブラリーの combine() メソッドを使う
        // これは find('list') と等価です

        $keyValueList = $articles->find()->combine('id', 'title');
        //debug($keyValueList);
        foreach ($keyValueList as $id => $title) {
            echo "$id : $title" . "<br/>";
        }
        */
        /** 
        // 上級な例
        $results = $articles->find()
            ->where(['id >' => 1])
            ->order(['id' => 'ASC'])
            ->map(function ($row) { // map() は Collection のメソッドで、クエリーを実行します
                $row->trimmedTitle = trim($row->title); // trim — 文字列の先頭および末尾にあるホワイトスペースを取り除く
                return $row;
            })
            ->combine('id', 'trimmedTitle') // combine() も Collection のメソッドです
            ->toArray(); // これも Collection のメソッドです
        debug($results);
        foreach ($results as $id => $trimmedTitle) {
            echo "$id : $trimmedTitle" . "<br/>";
        }
        */

        //クエリーの遅延評価 --- 次のいずれかが起こるまで実行されない
        //クエリーが foreach() でイテレートされる。
        //クエリーの execute() メソッドが呼ばれる。これは下層の statement オブジェクトを返し、 insert/update/delete クエリーで使うことができます。
        //クエリーの first() メソッドが呼ばれる。 SELECT (それがクエリーに LIMIT 1 を加えます) で構築された結果セットの最初の結果が返ります。
        //クエリーの all() メソッドが呼ばれる。結果セットが返り、 SELECT ステートメントでのみ使うことができます。
        //クエリーの toList() や toArray() メソッドが呼ばれる。
        /** 
        // データを select する --- 取得するフィールドを制限するのには、 select() メソッドを使う
        $query = $articles->find();
        //debug($query);
        $query->select(['id', 'title', 'slug']);
        foreach ($query as $row) {
            echo $row->id . " : " . $row->title . " : " . $row->slug . "<br/>";
        }
        */
        /** 
        // フィールドのエイリアス (別名) をセットする
        $query = $articles->find();
        $query->select(['pk' => 'id', 'aliased_title' => 'title', 'body']);

        $keyValueList = $query->combine('pk', 'aliased_title');
        //echo "hello!";
        foreach ($keyValueList as $pk => $aliased_title) {
            echo "$pk : $aliased_title" . "<br/>";
            
        }
        */ 
        /** 
        // distinct() メソッドを使う
        $query = $articles->find();
        $query->select(['id','user_id'])
            ->distinct(['user_id'])
            ->combine('id','user_id');
        foreach ($query as $key => $value) {
            echo "$key : $value" . "<br/>";
            //echo "hello!" . "<br/>";
            debug($value);
        }
        */ 
        /** 
        // 基本の条件をセットする  // 条件は AND で連結されます
        $query = $articles->find();
        $query->where(['title' => 'First Post', 'published' => false]);
        foreach ($query as $key => $value) {
            echo "$key : $value" . "<br/>";
            echo "value->id : $value->id" . "<br/>";
            echo "value->user_id : $value->user_id" . "<br/>";
            echo "value->title : $value->title" . "<br/>";
            //debug($value);
        }
        */ 

        /** 
        // where() を複数回呼んでもかまいません
        $query = $articles->find();
        $query->where(['title' => 'First Post'])
            ->where(['published' => false]);
        foreach ($query as $key => $value) {
            echo "$key : $value" . "<br/>";
            echo "value->id : $value->id" . "<br/>";
            echo "value->user_id : $value->user_id" . "<br/>";
            echo "value->title : $value->title" . "<br/>";
            //debug($value);
        }
        */

        /**  
        // 無名関数を where() メソッドに渡す
        // 渡された無名関数は、第一引数を \Cake\Database\Expression\QueryExpression のインスタンス、
        // 第二引数を \Cake\ORM\Query として受け取ります
        $query = $articles->find()
            ->limit(20);
        $query->where(function ($exp, $query) {
            return $exp->eq('published', false);
        });
        $query->where(['id >' => 1]);
        foreach($query as $key => $value){
            echo  "$key : $value->id : $value->title" . "<br//>";
        }
        */ 

        // 行の数を制限したり、行のオフセットをセットする
        // 50 から 100 行目をフェッチする
        /** 
        $query = $articles->find()
        ->limit(50)
        ->page(2);
        */

         
        // SQL 関数を使う
        // 参考サイト　https://www.ritolab.com/entry/67#select_sql_func_date_format
        /** 
        // SELECT COUNT(*) count FROM ... になる
        $query = $articles->find();
        //foreach($query as $key => $value){
        //    echo  "$key : $value->id : $value->title" . "<br//>";
        //}
        $cquery = $query->select(['count' => $query->func()->count('*')]);
        //debug($cquery);
        //$result = $cquery->toArray();
        $result = $cquery->toList();
        //debug($result);
        echo "record count : " . $result[0]->count . "<br/>";
        echo "<pre>";
        //var_dump($result);
        echo "</pre>";
        */ 

        // 多くのおなじみの関数が func() メソッドとともに作成できます:
        // sum() 合計を算出します。引数はリテラル値として扱われます。
        // avg() 平均値を算出します。引数はリテラル値として扱われます。
        // min() カラムの最小値を算出します。引数はリテラル値として扱われます。
        // max() カラムの最大値を算出します。引数はリテラル値として扱われます
        // count() 件数を算出します。引数はリテラル値として扱われます。
        // concat() ２つの値を結合します。引数はリテラルだとマークされない限り、 バインドパラメーターとして扱われます。
        // coalesce() Coalesce を算出します。引数はリテラルだとマークされない限り、 バインドパラメーターとして扱われます。
        // dateDiff() ２つの日にち/時間の差を取得します。引数はリテラルだとマークされない限り、 バインドパラメーターとして扱われます。
        // now() 'time' もしくは 'date' を取得します。引数で現在の時刻もしくは日付のどちらを 取得するのかを指定できます。
        // extract() SQL 式から特定の日付部分(年など)を返します。
        // dateAdd() 日付式に単位時間を追加します。
        // dayOfWeek() SQL の WEEKDAY 関数を呼ぶ FunctionExpression を返します。
        

        // SQL 関数に渡す引数には、リテラルの引数と、バインドパラメーターの２種類がありえます
        //  識別子やリテラルのパラメーターにより、カラムや他の SQL リテラルを参照できます
        /**  
        $query = $articles->find();
        $concat = $query->func()->concat([
            'Articles.id' => 'identifier',
            ' : ',
            'Articles.title' => 'literal'
        ]);
        $query->select(['title' => $concat])
        ->sql();
        //debug($query);
        foreach($query as $key => $value){
            echo  "$key : $value->title" . "<br//>";
        }
        // $keyは$queyのenumである（0,1,2,3......22）
        /** 
        $result = $query->toList();
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
        */ 

        // literal の値を伴う引数を作ることで、 ORM はそのキーをリテラルな SQL 値として扱うべきであると 知ることになります
        // identifier の値を伴う引数を作ることで、ORM は、そのキーがフィールドの 識別子として扱うべきであると知ることになります。上記では MySQL にて下記の SQL が生成されます。
        // 上記では MySQL にて下記の SQL が生成されます
        
        // SELECT CONCAT(Articles.title, :c0, Categories.name, :c1, (DATEDIFF(NOW(), Articles.created))) FROM articles;
        
        // クエリーが実行される際には、 :c0 という値に ' - CAT' というテキストがバインドされる
        /** 
        $query = $articles->find();
        $year = $query->func()->year([
            'created' => 'identifier'
        ]);
        $time = $query->func()->date_format([
            'created' => 'identifier',
            "'%y.%m.%d'" => 'literal'  //"'%H:%i'"  %Y.%m.%d
        ]);
        $query->select([
            'yearCreated' => $year,
            'timeCreated' => $time
        ]);
        //debug($query);
        foreach($query as $row) {
            echo $row->yearCreated . " : " . $row->timeCreated . "<br/>";
        }
        */ 

        // 安全ではないデータを、 SQL 関数やストアドプロシージャに渡す必要がある際には必ず、
        // 関数ビルダーを使うということを覚えておいてください。

        // 集約 - Group と Having
        // count や sum のような集約関数を使う際には、 group by や having 句を使いたいことでしょう

        // Case 文
        // case 式により if ... then ... else のロジックを SQL の中に実装することができます。
        // これは条件付きで sum や count をしなければならない 状況や、条件に基いてデータを特定しなければならない状況で、
        // データを出力するのに便利です

        
         
        // エンティティーの代わりに配列を取得
        // データベースの結果をエンティティーに変換する処理は、ハイドレーション (hydration) と呼ばれます
        /**  
        $query = $articles->find();
        $query->enableHydration(false); // エンティティーの代わりに配列を返す //enableHydration(false) 
        $result = $query->toList(); // クエリーを実行し、配列を返す
        //debug($result);
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
        */

        // 計算フィールドを追加する
        // 計算フィールドや生成された (derived) データをいくつか追加する必要があるなら、formatResults() メソッドを使う
        // これにより軽い負荷で、結果セットを map することができます

        // 高度な条件
        // クエリービルダーは複雑な where 句の構築を簡単にします
        // グループ化された条件は、 where() と Expression オブジェクトを組み合わせることで表現できます。
        // 単純なクエリーの場合、条件の配列を使用して条件を作成できます


        // 未加工の式
        // クエリービルダーでは目的の SQL が構築できない場合、Expression オブジェクトを使って、 SQL の断片をクエリーに追加することができます。
        /** 
        $query = $articles->find();
        $expr = $query->newExpr()->add('1 + 1');
        $query->select(['two' => $expr]);
        debug($query);
        $results = $query->first();
        debug($results->two);
        */
        // 結果を取得する

        // クエリーができたら、それから行を受け取りたいでしょう。これにはいくつかの方法があります。
        // クエリーをイテレートする
        /** 
        foreach ($query as $row) {
            // なにかする
        }
        // 結果を取得する
        $results = $query->all();
        */
        // Query オブジェクトでは Collection のメソッドがどれでも使えます。それらで結果を前処理したり、変換したりすることができます。
        // コレクションのメソッドを使う
        /** 
        $ids = $query->map(function ($row) {
            return $row->id;
        });

        $maxAge = $query->max(function ($max) {
            return $max->age;
        });
        */
        // first や firstOrFail を使って、単一のレコードを受け取ることができます。
        // 最初の行だけを取得する
        //$row = $query->first();
        // 最初の行を取得する。できないなら例外とする。
        //$row = $query->firstOrFail();

        // レコードの合計数を返す
        //$total = $articles->find()->where(['is_active' => true])->count();


        // 関連付くデータをロードする
        // 他のテーブルから関連するデータを フェッチするためにクエリーを合成する技術を イーガーロード (eager load) といいます
        /** 
        // コントローラーやテーブルのメソッド内で
        // find() のオプションとして
        $query = $articles->find('all', ['contain' => ['Users']]);

        // クエリーオブジェクトのメソッドとして
        $query = $articles->find('all');
        $query->contain(['Users']);
        //debug($query);
        $result = $query->toList();
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
        */

        // ロードする関連データを定義するためのネストされた配列を使って、ネストされた関連データを ロードすることができます
        // contain に条件を渡す

        // コントローラーやテーブルのメソッド内で
        // find() のオプションとして
        //$query = $articles->find('all', ['contain' => ['Users']]);

        // クエリーオブジェクトのメソッドとして
        //$query = $articles->find('all');
        //$query->contain(['Users']);
        
        // 関連によって返される列を限定し、条件によってフィルターすることができます
        /**  Artixlesの全てのデーター後ロードされる
        $query = $articles->find()->contain('Users', function ($q) {
            return $q
                ->select(['id', 'email'])
                ->where(['Users.email' => 'fumiko.sugai@gmail.com']);
        }); 
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . " : " . $article->user->id . " : " . $article->user->email . "<br/>";
            // fumiko.sugai@gmail.com 以外の行の印刷でエラーが発生
        };
        */ 

        // 関連によってフェッチされるフィールドを限定する場合、外部キーの列が確実に select されなければなりません 
        // 外部キーのカラムが select されない場合、関連データが 最終的な結果の中に無いということがおこります。
    
        // 関連を含んだソート
        // 関連を HasMany や BelongsToMany でロードした時、 sort オプションで、これら関連データを ソートすることができます。
        /** 
        $query->contain([
            'Comments' => [
                'sort' => ['Comments.created' => 'DESC']
            ]
        ]);
        */

        // 関連付くデータでフィルターする
        // matching と joins を用いた関連データによるフィルタリング

        // matchingを使う
        /**
        $query = $articles->find()
            ->matching('Users', function ($q) {
                return $q->where(['Users.email' => 'fumiko.sugai@gmail.com']);
            });
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . " : " . $article->_matchingData['Users']->email . "<br/>";    
        };

        $query = $articles->find();
        $query->matching('Tags', function ($q) {
            return $q->where(['Tags.title' => 'cakephp']);
        });
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . " : " . $article->_matchingData['Tags']->title . "<br/>";    
        };
        */ 
        // 関連から「マッチ ('matched') した」ことで取得されるデータはエンティティーの _matchingData プロパティーで利用可能です。
        // 同一の関連を match かつ contain している場合、結果には _matchingData プロパティーと標準の関連系のプロパティーの両方があることになります。 

        // innerJoinWith を使う(内部結合)
        // matching() を使いたいものの、結果セットにフィールドをロードしたくない状況もあるかもしれません。
        // この目的で innerJoinWith() を使うことが出来ます。
        /** 
        $query = $articles->find();
        $query->innerJoinWith('Tags', function ($q) {
            return $q->where(['Tags.title' => 'cakephp']);
        });
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . "<br/>";    
        };
        */

        // innerJoinWith() メソッドは matching() と同様に動きます。
        // つまり、ドット記法を使うことで深くネストする関連を join できます。
        /** 
        $query = $articles->find()->innerJoinWith(
            'Users', function ($q) {
                return $q->where(['Users.email' => 'tom.sugai@gmail.com']);
            }
        );
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . "<br/>";    
        };
        // 違いは結果セットに追加のカラムが追加されず、 _matchingData プロパティーがセットされないことだけです
        */

        // notMatching を使う
        // matching() の対義語となるのが notMatching() です。
        /** 
        // この関数は結果を、 特定の関連に繋がっていないものだけにフィルターするようにクエリーを変更します。
        $query = $articles
        ->find()
        ->notMatching('Tags', function ($q) {
            return $q->where(['Tags.title' => 'abc']);
        });
        foreach($query as $article) {
            //debug($article);
            echo $article->id . " : " . $article->title . "<br/>";    
        };
        // 上記の例は 'abc' という単語でタグ付けされていない、すべての記事(Article)を検索します。 
        // このメソッドを HasMany の関連にも同様に使うことができます。
        // たとえば、10日以内に公開 (published) されていない記事 (Article) のすべての作者 (Author) を検索することができます。
        // matching() 関数の正反対となる notMatching() ですが、
        // いかなるデータも結果セットの _matchingData プロパティーに追加しないということを覚えておいてください。
        */

        // leftJoinWith を使う(leftOuterJoin:外部結合)
        /** 
        // 時には、すべての関連レコードをロードしたくはないが、関連に基いて結果を計算したいということが あるかもしれません。
        // たとえば、記事 (Article) の全データと一緒に、記事ごとのコメント (Comment) 数をロードしたい場合には、
        // leftJoinWith() 関数が使えます。
        $query = $articlesTable->find();
        $query->select(['total_comments' => $query->func()->count('Comments.id')])
            ->leftJoinWith('Comments')
            ->group(['Articles.id'])
            ->enableAutoFields(true); // 3.4.0 より前は autoFields(true); を使用

        // 上記クエリーの結果は Article データの結果に加え、データごとに total_comments プロパティーが含まれます。
        */
        /** 
        // exercise 
        $tags = $articles->tags->find('list');
        // 課題　find('list')の結果をtag->idの順番に並べ替える
        //debug($tags);
        foreach($tags as $key => $tag){
            echo "key : $key" . " : " . $tag . "<br/>";
        }
        // 課題　articleのリストの後ろに複数のタグを表示する 
        $query = $articles->find('all')->contain(['Tags']);
        foreach ($query as $article) {           
            if($article->tags != null){
                echo $article->id . " : " . $article->title . " : " . $article->tags[0]->title . "<br/>";   
            } else {
                echo $article->id . " : " . $article->title . " : " . "Not Taged" . "<br/>";
            }
        } 
        */
        // フェッチの戦略を変更する
        // select 戦略 (strategy) を使う
        /** 
        $articles->hasOne('FirstComment', [
            'className' => 'Comments',
            'foreignKey' => 'article_id'
        ]);
        $query = $articles->find()->contain([
            'FirstComment' => [
                'strategy' => 'select',
                'queryBuilder' => function ($q) {
                    return $q->order(['FirstComment.created' =>'ASC'])->limit(1);
                }
            ]
        ]);
        */
        // サブクエリー戦略でフェッチする
        // hasMany と belongsToMany の関連データをロードする際、関連を最適化する良い方法は、 subquery 戦略を使うことです
        /** 
        $query = $articles->find()->contain([
            'Comments' => [
                    'strategy' => 'subquery',
                    'queryBuilder' => function ($q) {
                        return $q->where(['Comments.approved' => true]);
                    }
            ]
        ]);
        */

        // 結果セットを使いこなす
        // all() を使ってクエリーが実行されたら、 Cake\ORM\ResultSet のインスタンスが 得られます。
        // このオブジェクトはクエリーから得られた結果のデータを強力に操作する方法を提供します。 
        // クエリーオブジェクトと同様に、ResultSets は Collection ですので、 
        // ResultSet オブジェクトのコレクションメソッドをどれでも使うことができます。
        
        //結果セットの結果は cache/serialize したり、API 用に JSON エンコードしたりすることができます。
        /** 
        // コントローラーやテーブルのメソッド内で
        $results = $query->all();

        // Serialized
        $serialized = serialize($results);

        // Json
        $json = json_encode($results);
        */
        /** 
        // ResultSet から最初/最後のレコードを取得する
        // first() と last() メソッドを使うことで、結果セットから該当のレコードを取得することができます。
        $result = $articles->find('all')->all();
        // 最初・最後の結果を取得します。
        $row = $result->first();
        $row = $result->last();
        // ResultSet から任意の場所を指定して取得する
        //skip() と first() を使うことで ResultSet から任意のレコードを取得できます。
        $result = $articles->find('all')->all();
        // ５番目のレコードを取得する
        $row = $result->skip(4)->first();
        // Query や ResultSet が空かどうかをチェックする
        // Query や ResultSet オブジェクトの isEmpty() メソッドを使うことで１行以上あるかどうかを確認できます。 
        // Query オブジェクトで isEmpty() メソッドを呼び出した場合はクエリーが評価されます。
        // クエリーをチェックします
        $query->isEmpty();
        // 結果をチェックします
        $results = $query->all();
        $results->isEmpty();
        */

        /** 
        $user = $users->get(5);
        $reggedYear = $user->created->format('ymd');
        $email = $user->email;
        echo $reggedYear . ":" . $email . "<br/>";
        */
    }

    public function validate(){
        $this->autoLayout = true;
        $this->autoRender = false;

        
        // テーブルオブジェクトを取得
        $articles = TableRegistry::getTableLocator()->get('Articles');
        $tags = TableRegistry::getTableLocator()->get('Tags');
        $users = TableRegistry::getTableLocator()->get('Users');
        
        
    }

    // データを保存する
    public function dataKeep(){
        $this ->autoLayout = true;
        $this->autoRender = false;

        $articlesTable = TableRegistry::getTableLocator()->get('Articles');
        // insert
        /**
        $article = $articlesTable->newEntity();
        $article->user_id = 5;
        $article->title = '日本語バリデーションの確認ー２';
        $article->body = '日本語の記事の本文ですー２';
       
        if ($articlesTable->save($article)) {
            // $article エンティティーは今や id を持っています
            $id = $article->id;       
        }
        echo $id;
        */
        /** 
        // update
        $article = $articlesTable->get(67); // id 12 の記事を返します
        $article->title = 'CakePHP は最高です-----！';
        $articlesTable->save($article);
        echo "record-67 updated" ."<br/>";
        echo "isNew ::: " . $article->isNew();
        */
        /** 
        // アソシエーションの保存
        $user = $articlesTable->Users->findByEmail('tom.sugai@gmail.com')->first();
        //debug($user);

        $article = $articlesTable->newEntity();
        $article->title = 'tom の記事-5';
        $article->user = $user;

        if ($articlesTable->save($article)) {
            // 外部キー値は自動でセットされます。
            echo $article->user_id;
            echo $article->id;
        }
        */
        /**   
        // save() メソッドでアソシエーションのレコードを作成する
        // 記事へのコメントの付加機能を検証・・・Commentsテーブルの追加と関連の設定を記述

        $firstComment = $articlesTable->Comments->newEntity();
        //$firstComment->user_id = 7;　**** user_idを使用するとエラーが発生した
        $firstComment->body = 'CakePHP の機能は傑出しています';

        $secondComment = $articlesTable->Comments->newEntity();
        //$firstComment->user_id = 7;
        $secondComment->body = 'CakePHP のパフォーマンスは素晴らしい！';
        
        $tag1 = $articlesTable->Tags->findByTitle('cakephp')->first();
        $tag2 = $articlesTable->Tags->newEntity();
        $tag2->title = 'すごいzo-';
         
        $article = $articlesTable->get(71);
        $article->comments = [$firstComment, $secondComment];
        $article->tags = [$tag1, $tag2];
        //$article->user_id = 5;
        debug($article);
        $articlesTable->save($article);
        */

        /**
        // ***　以下は未検証　***
        // 多対多レコードの関連付け : link
        // 前の例は一つの記事といくつかのタグを関連付ける方法を例示しています。 
        // 同じことをするための別の方法として、アソシエーション側で link() メソッドを使用する方法があります。
        $tag1 = $articlesTable->Tags->findByTitle('cakephp')->first();
        $tag2 = $articlesTable->Tags->newEntity();
        $tag2->title = 'すごい';
        $article = $articlesTable->get(62);
        // debug($article);
        // $articlesTable->save($article); と同じ操作
        $articlesTable->Tags->link($article, [$tag1, $tag2]);
        // 多対多レコードの紐付け解除 : unlink
        // プロパティーを直接設定または変更してレコードを更新した時は、データ検証は行われませんので、 
        // フォームデータを受け取る時にはこれは問題になります。
         */

        // リクエストデータのエンティティーへの変換
        // リクエストデータを リクエスト中の配列形式から変換する必要があります。ORM が使用するエンティティーです。
        // 単一のエンティティーの変換には次の方法を使います。
        // コントローラーの中で
        $articlesTable = TableRegistry::getTableLocator()->get('Articles');

        // 検証して Entity オブジェクトに変換します。
        //$entity = $articlesTable->newEntity($this->request->getData());
        $artid = 60;
        $entity = $articlesTable->get($artid);
        $result = $articlesTable->delete($entity);
        debug($result);
        echo "deleted $artid";



    } 

    public function conn(){
        $this->autoLayout = true;
        $this->autoRender = false;

        //$request = $this->request;
        //debug($request);

        //$controllerName = $this->request->getParam('controller');
        //debug($controllerName);

        //$params = $this->request->getAttribute('params');
        //debug($params);

        //$passedArgs = $this->request->getParam('pass');
        //debug($passedArgs);

        /** 
        $db = ConnectionManager::get('default');
        $collection = $db->getSchemaCollection();
        debug($collection);

        // テーブル名の取得
        $tables = $collection->listTables();
        debug($tables);

        // 単一テーブル (Schema\TableSchema インスタンス) の取得
        $tableSchema = $collection->describe('articles');
        debug($tableSchema);
        */

        $connection = ConnectionManager::get('default');
        $results1 = $connection->execute('SELECT * FROM articles')->fetchAll('assoc');
        //debug($results1);
        foreach ($results1 as $row) {
            echo $row['id'] . ":"  . $row['user_id'] . ":" . $row['title'] . $row['slug'] . $row['body'] . $row['published'] . $row['created'] . "<br/>";
        }
        $results2 = $connection
            ->newQuery()
            ->select('*')
            ->from('articles')
            ->where(['id >' => 10])
            ->order(['title' => 'DESC'])
            ->execute();
            //->fetchAll('assoc');
        $params = $this->request->getQuery();
        //debug($params);
        //$params = $this->request->getQueryParams();
        //debug($params);
        //debug($results2);
        foreach ($results2 as $row) {
            //debug($row);
            echo $row['title'] . "<br/>";
            //print_r($row);
        }   
    }
}
?>