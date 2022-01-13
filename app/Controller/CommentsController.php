<?php

class CommentsController extends AppController {
    public $helpers = array('Html', 'Form');

    public function add() {
        if ($this->request->is('ajax')) {
            if ($this->Comment->save($this->request->data)) {
                $this->autoRender = false;
                $this->autoLayout = false;
                $this->header('Content-Type: application/json');
                $this->Session->setFlash('Success!');
            }
        }
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->request->is('ajax')) {
            if ($this->Comment->delete($id)) {
                $this->autoRender = false;
                $this->autoLayout = false;
                $response = array('id' => $id);
                $this->header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        }
        $this->redirect(array('controller'=>'posts', 'action'=>'index'));
    }
}