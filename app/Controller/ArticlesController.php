<?php

class ArticlesController extends AppController {
	public $uses = array('Article', 'Item');  

    public function index() {
		$this->set('articles', $this->Article->find('all'));
        $this->set('title_for_layout', '記事一覧');	
	}

    public function view($id = null) {
		$this->Article->id = $id;
		$article = $this->Article->read();
		$items = $this->Item->find('all', array('conditions' => array('Item.article_id' => $id)));
		$ordered_items = array();
		//init item_order
		if($article["Article"]["item_order"] == ""){
			$item_order = array();
			foreach($items as $item){
				array_push($item_order, $item["Item"]["id"]);
			}
			$article["Article"]["item_order"] = implode(",", $item_order);
			$this->Article->save($article);
		}
		foreach(explode(",", $article["Article"]["item_order"]) as $item_id){
			foreach($items as $item){
				if($item["Item"]["id"] == $item_id){
					array_push($ordered_items, $item);
				}
			}
		}
		$this->set('article', $article);
		$this->set('items', $ordered_items);
		$this->set('title_for_layout', '記事詳細');
	}

	public function move() {
		$this->autoRender = false;
		$this->autoLayout = false;
		$this->header('Content-Type: application/json');
		if($this->request->is('ajax')){
			$this->Article->id = intval($this->request->data['article_id']);
			$move_from = intval($this->request->data['move_from']);
			$move_to = intval($this->request->data['move_to']);
			$article_item_order = explode(',', $this->Article->field('item_order'));
			$item_id = $article_item_order[$move_from];
			unset($article_item_order[$move_from]);
			array_splice($article_item_order, $move_to, 0, $item_id);
			$this->Article->saveField('item_order', implode(',', $article_item_order));
			$this->Session->setFlash('Success!');
		}
		else {
			$this->Session->setFlash('failed!');
		}
	}
}