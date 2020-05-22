<?php
    class template {
        public $dirTemplates;
        public $data = array();

        public function __construct(string $dirTemplates) {
            $this -> dirTemplates = $dirTemplates;
        }

        public function set(string $name, $values) {
            $this -> data[$name] = $values;
        }

        public function delete(string $name) {
            unset($this -> $data[$name]);
        }

        public function __get(string $name) {
            if (isset($this -> data[$name]))
                return $this -> data[$name];
            else
                return null;
        }

        public function display(string $template) {
            $template = $this -> dirTemplates . $template . ".tpl";
            ob_start();
            include($template);
            echo ob_get_clean();
        }
    }
?>