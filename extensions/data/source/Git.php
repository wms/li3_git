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
        $data = $query->data();

        if($result = $this->_writeFile($data, $options)) {
            if($query->entity()) {
                $query->entity()->sync($result);
            }
            return true;
        }
        return false;
    }

    public function read($query, array $options = array()) {
        return false;
    }

    public function update($query, array $options = array()) {}
    public function delete($query, array $options = array()) {}

    /**
     * Write a blob and return the sha1 oid
     * 
     * @param array $content
     * @return string
     */
    private function _writeBlob($content) {
        return $this->repo->write($content, 3);
    }

    /**
     * Write a blob and link it to a tree entry.
     * For now, only creating under the root tree is supported.
     * 
     * @param array $data   array containing 'name' and 'content' keys
     * @param array $options
     * @return boolean
     */
    private function _writeFile(array $data = array(), $options) {
        if($sha1 = $this->_writeBlob($data['content'])) {
            $builder = new \Git2\TreeBuilder();
            $entry = new \Git2\TreeEntry(array(
                'name' => $data['name'],
                'oid' => $sha1,
                'attributes' => 0100644
            ));
            $builder->insert($entry);

            return $builder->write($this->repo);
        }
        return false;
    }

}
?>
