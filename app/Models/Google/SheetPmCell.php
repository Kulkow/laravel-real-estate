<?php
namespace App\Models\Google;

class SheetPmCell {

    private $row;
    private $col;
    private $alias;
    private $title;
    private $value;

    public function __construct($col, $row, $alias, $title, $value)
    {
        $this->row = $row;
        $this->col = $col;
        $this->alias = $alias;
        $this->title = $title;
        $this->value = $value;
    }

    public function row(){
        return $this->row;
    }

    public function col(){
        return $this->col;
    }

    public function alias(){
        return $this->alias;
    }

    public function title(){
        return $this->title;
    }

    public function value(){
        return $this->value;
    }

    public function toJson(){
        return [
            's' => ''
        ];
    }
}
