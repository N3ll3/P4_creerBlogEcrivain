<?php

namespace Model;

class Comment
{
    protected $_id;
    protected $_author;
    protected $_content;
    protected $_postId;
    protected $_commentDate;
    protected $_isFlagged = false;


    public function writeComment()
    { }
    public function modifyComment()
    { }
    public function deleteComment()
    { }
}
