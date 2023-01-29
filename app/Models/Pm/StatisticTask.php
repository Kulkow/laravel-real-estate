<?php
namespace App\Models\Pm;

use Illuminate\Database\Eloquent\Model;

class StatisticTask extends Model
{
    protected $table = 'statistic_tasks';
    public $incrementing = true;
    public $timestamps = false;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'type',
        'lead_time',
        'description',
        'comment',
        'employe_id',
        'plan_task_id',
        'pm_task_id',
        'date'
    ];


    public function convertLink($link): int
    {
        $link = trim($link);
        $link = trim($link,'/');
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
        return intval(md5($link));
    }

    public function getStatId()
    {
        $find =  $this->where([['employe_id', $this->employe_id], ['pm_task_id' , $this->pm_task_id], ['date' , $this->date]])->first();
        if($find){
            return $find->id;
        }
        return false;
    }



    public function owner()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function plan()
    {
        return $this->belongsTo(PlanTask::class, 'plan_task_id');
    }
}
