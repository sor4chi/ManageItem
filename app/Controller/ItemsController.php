<?php

class ItemsController extends AppController {
	public $uses = array('Article', 'Item');
  
	public function add() {
		if($this->request->is('ajax')){
			$this->autoRender = false;
			$this->autoLayout = false;
			$this->header('Content-Type: application/json');
			if($this->Item->save($this->request->data)){
				$this->Article->id = intval($this->request->data['article_id']);
				$this->Article->saveField('item_order', $this->Article->field('item_order').','.$this->Item->id);
				$this->Session->setFlash('Success!');
			}
			else {
				$this->Session->setFlash('failed!');
			}
		}
	}

	public function edit($id = null) {
		$this->Item->id = $id;
		if($this->request->is('ajax')){
			$this->autoRender = false;
			$this->autoLayout = false;
			$this->header('Content-Type: application/json');
			if($this->Item->save($this->request->data)){
				$this->Session->setFlash('Success!');
			}
			else {
				$this->Session->setFlash('failed!');
			}
		}
	}

	public function delete($id) {
        if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->autoLayout = false;
			$this->header('Content-Type: application/json');
            if ($this->Item->delete($id)) {
				$this->Article->id = intval($this->request->data['article_id']);
				$article_item_order = explode(',', $this->Article->field('item_order'));
				foreach ($article_item_order as $item_id ) {
					if ($item_id == $id) {
						unset($article_item_order[array_search($item_id, $article_item_order)]);
					}
				}
				$this->Article->saveField('item_order', implode(',', $article_item_order));
				$this->Session->setFlash('Success!');
            }
			else {
				$this->Session->setFlash('failed!');
			}
        }
        $this->redirect(array('controller'=>'articles', 'action'=>'index'));
	}
}