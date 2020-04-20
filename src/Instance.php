<?php


namespace AutoCode;


trait Instance
{
    /**
     * @var self |Instance
     */
    private self $class;

    /**
     * Instance constructor.
     */
    private function __construct()
    {
        $this->class = new self();
    }

    /**
     * @return $this
     */
    public function getInstance():self
    {
        if($this->class!==null && $this->class instanceof self){
            return $this->class;
        }
        $class = new self();
        $this->class = $class;
        $methodArr = get_class_methods(__FUNCTION__);
        if(in_array('init', $methodArr)){
            $this->init();
        }
    }
}