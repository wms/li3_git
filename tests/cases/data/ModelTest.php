<?php
namespace li3_git\tests\cases\data;

use \lithium\data\Connections;
use li3_git\tests\mocks\data\MockModel;

class ModelTest extends \lithium\test\Unit {

    public function setUp() {
        $testRepo = DIRNAME(DIRNAME(__DIR__)) . '/mocks/data/testRepo';

        if(!Connections::get('gitTest')) {
            Connections::add('gitTest', array(
                'type' => 'Git',
                'path' => $testRepo
            ));
        }
    }

    public function testCreate() {
        $document = MockModel::create(array(
            'name' => 'Test Document',
            'content' => 'This is a test document'
        ));

        $this->assertTrue($document->save());
    }

    public function testSetIdOnCreate() {
        $document = MockModel::create(array(
            'name' => 'Test Document',
            'content' => 'This is a test document'
        ));

        $document->save();

        $this->assertEqual(
            '746daa7560dd3ecaecbd237956bf4cc926d51341',
            $document->id
        );
    }
}

?>
