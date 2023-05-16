<?php
namespace App\PmReports;

use App\Models\Pm\Employe;
use App\Models\Pm\PlanTask;
use App\Models\Pm\StatisticTask;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PmReportBase {

    private $employe_id = null;
    private $date = null;

    public function __construct($employe_id = null)
    {
        $this->employe_id = $employe_id;
    }

    public function employe()
    {
        $employe = Employe::find($this->employe_id);
        if(! $employe){
            throw new NotFoundHttpException('not find employe');
        }
        return $employe;
    }

    public function day($date = null)
    {

    }

    public function week($week = 'this') : array
    {
        $id = $this->employe_id;
        $start = date('Y-m-d', strtotime('monday '.$week.' week'));
        $end = date('Y-m-d', strtotime('sunday '.$week.' week'));
        $whereStats = [
            [
                'employe_id', $id
            ],
            [
                'date', '>=', $start
            ],
            [
                'date', '<=', $end
            ],
        ];
        $time = new \DateTime($start);
        while ($time->getTimestamp() < strtotime($end)){
            $time = $time->add(new \DateInterval('P1D'));
        }
        $statistic_tasks = StatisticTask::where($whereStats)->with(['plan'])->orderBy('date', 'asc')->paginate(100);
        $plans = PlanTask::where($whereStats)->with(['owner'])->orderBy('date', 'asc')->paginate(100);
        $statistics = [
            'plan' => 0,
            'total' => 0,
            'days' => [],
            'tasks_index' => [],
            'duples' => [],
        ];
        foreach ($statistic_tasks as $statistic){
            $day = $statistic->date;
            $lead_time = $statistic->lead_time;
            $time = 0;
            if($statistic->plan){
                $time = $statistic->plan->time;
            }
            $link = $statistic->link;
            $type = $statistic->type;
            if(! isset($statistics['days'][$day])){
                $statistics['days'][$day] = [
                    'plan' => 0,
                    'complete' => 0,
                    'types' => [],
                    'tasks' => [
                        'plans' => [],
                        'completed' => [],
                        'not_plans' => [],
                        'not_completed' => [],
                    ]
                ];
            }
            $statistics['days'][$day]['plan'] += $time;
            $statistics['days'][$day]['complete'] += $lead_time;

            $statistics['plan'] += $time;
            $statistics['total'] += $lead_time;
            $key = md5($link);
            if(! empty($statistics['tasks_index'][$key])){
                if(! isset($statistics['duples'][$key])){
                    $statistics['duples'][$key] = [
                        'link' => $link,
                        'days' => [
                            $statistics['tasks_index'][$key]
                        ]
                    ];
                }
                $statistics['duples'][$key]['days'][] = $day;
            }
            $statistics['tasks_index'][$key] = $day;
            $statistics['days'][$day]['tasks']['completed'][$key] = $link;
            if($time > 0){
                $statistics['days'][$day]['tasks']['plans'][$key] = $link;
            }else{
                $statistics['days'][$day]['tasks']['not_plans'][$key] = $link;
            }
            if(! isset($statistics['days'][$day]['types'][$type])){
                $statistics['days'][$day]['types'][$type] = 0;
            }
            $statistics['days'][$day]['types'][$type] += 1;
        }
        foreach ($plans as $statistic){
            $day = $statistic->date;
            $time = $statistic->time;
            $link = $statistic->link;
            $type = $statistic->type;
            if(! isset($statistics['days'][$day])){
                $statistics['days'][$day] = [
                    'plan' => 0,
                    'complete' => 0,
                    'types' => [],
                    'tasks' => [
                        'plans' => [],
                        'completed' => [],
                        'not_plans' => [],
                        'not_completed' => [],
                    ]
                ];
            }
            $key = md5($link);
            if(! empty($statistics['days'][$day]['tasks']['plans'][$key])){
                continue;
            }

            $statistics['days'][$day]['plan'] += $time;
            $statistics['plan'] += $time;

            $statistics['days'][$day]['tasks']['plans'][$key] = $link;
            $statistics['days'][$day]['tasks']['not_completed'][$key] = $link;

            if(! isset($statistics['days'][$day]['types'][$type])){
                $statistics['days'][$day]['types'][$type] = 0;
            }
            $statistics['days'][$day]['types'][$type] += 1;
        }
        return $statistics;
    }
}
