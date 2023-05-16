<?php
namespace App\Models\Google;
use Illuminate\Support\Str;
use App\Models\Google\SheetPmCell;

class SheetPmDay {

    private  $cols = [];
    private  $_cols = [];
    private  $tasks = [];
    private  $values = [];
    private  $last = 0;

    public function __construct(array $values)
    {
        $index = 0;
        foreach ($values as $row){
            if(++$index == 1){
                foreach ($row as $i => $cell){
                    $alias = Str::slug($cell);
                    $this->cols[$alias] = $cell;
                    $this->_cols[$i] = $alias;
                }
            }else{

                $taskId = $row[0] ?? null;
                if(! $taskId){
                    continue;
                }
                $taskId = $this->taskId($taskId);
                if(! $taskId){
                    continue;
                }
                $this->values[$taskId] = [];
                $this->tasks[$taskId] = [];
                foreach ($this->_cols as $i => $alias){
                    $title = $this->cols[$alias];
                    $v = $row[$i] ?? '';
                    $cell = new SheetPmCell($index, $i, $alias, $title, $v);
                    $this->values[$taskId][$alias] = $cell;
                    $this->tasks[$taskId][$alias] = $v;
                }
            }
            $this->last = $index;
        }
    }

    public function taskId($link)
    {
        $link = trim(trim($link),'/');
        $links = explode('/',$link);
        if(count($links) > 1){
            $id = array_pop($links);
            return intval($id);
        }
        $links = explode('.',$link);
        if(count($links) > 1){
            $id = array_pop($links);
            return intval($id);
        }
        return false;
    }

    public function cols() : array
    {
        return $this->cols;
    }

    public function lastRow()
    {
        return $this->last;
    }

    public function tasks() : array
    {
        return $this->tasks;
    }

    public function values() : array
    {
        return $this->values;
    }
}

