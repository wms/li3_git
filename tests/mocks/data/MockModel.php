<?php
namespace li3_git\tests\mocks\data;

class MockModel extends \lithium\data\Model {
    protected $_meta = array(
        'connection' => 'gitTest'
    );

    protected $_schema = array(
        'id' => array('type' => 'id'),
        'name' => array('type' => 'string'),
        'content' => array('type' => 'string')
    );
}

?>
