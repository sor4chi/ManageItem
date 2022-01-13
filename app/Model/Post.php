<?php

class Post extends AppModel {
    public $hasMany = "Comment";
    public $validate = array(
        'title' => array (
            'rule' => 'notEmpty',
            'message' => 'Blank is not allowed'
        ),
        'body' => array (
            'rule' => 'notEmpty',
            'message' => 'Blank is not allowed'
        )
    );
}