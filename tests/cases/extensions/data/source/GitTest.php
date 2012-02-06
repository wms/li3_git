<?php
namespace li3_git\tests\cases\extensions\data\source;

use \lithium\data\Connections;
use \lithium\core\Libraries;
use \li3_git\extensions\data\source\Git;

class GitTest extends \lithium\test\Unit {

    private $testBlob = 'This is a test blob';

    public function setUp() {

        $mockRepo = DIRNAME(DIRNAME(DIRNAME(DIRNAME(__DIR__)))) . '/mocks/data/testRepo';

        if(!Connections::get('gitTest')) {
            Connections::add('gitTest', array(
                'type' => 'Git',
                'path' => $mockRepo
            ));
        }

        $this->git = new Git(Connections::get('gitTest', array('config' => true)));
    }

    public function tearDown() {
        unset($this->git);
    }

    public function testConnect() {
        $this->assertTrue($this->git->isConnected());
    }

    public function testCreateBlob() {
        $this->assertTrue($this->git->create('blob', array('content' => $this->testBlob)));
    }

    public function testReadBlob() {
        $sha1 = $this->git->create('blob', array('content' => $this->testBlob));

        $this->assertEqual($this->testBlob, $this->git->read('blob', array('sha1' => $sha1)));
    }
}
?>
