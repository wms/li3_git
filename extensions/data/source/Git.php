<?php
namespace li3_git\extensions\data\source;

class Git extends \lithium\data\Source {

    public function connect() {
        if(!$this->isConnected()) {
            return $this->repo = new \Git2\Repository($this->_config['path']);
        }
        return false;
    }

    public function disconnect() {
        if($this->isConnected()) {
            unset($this->repo);
            return true;
        }
        return false;
    }

    public function isConnected(array $options = array()) {
        return isset($this->repo);
    }

    public function sources($class = null) {}
    public function describe($entity, array $meta = array()) {}
    public function relationship($class, $type, $name, array $options = array()) {}

    public function create($query, array $options = array()) {
        switch($query) {
        case "blob":
            if($options['content']) {
                if($sha1 = $this->repo->write($options['content'], 3)) {
                    return $sha1;
                }
            }
        }
        return false;
    }

    public function read($query, array $options = array()) {
        switch($query) {
        case "blob":
            if($options['sha1']) {
                if($content = $this->repo->lookup($options['sha1'])) {
                    return $content;
                }
            }
        }
        return false;
    }

    public function update($query, array $options = array()) {}
    public function delete($query, array $options = array()) {}
}
?>
