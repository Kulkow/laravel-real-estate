<?php
namespace App\Http\Controllers\Admin\Pm;

use App\Http\Controllers\Controller;

use App\Models\Pm\Employe;
use App\Models\Pm\StatisticTask;
use App\Models\Pm\PlanTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StatisticTasksContoller extends Controller
{

    public function index()
    {
        $list = StatisticTask::paginate(50);
        return view('admin.pm.statistics.index', ['list' => $list,]);
    }

    public function graphic($id = null)
    {
        $employe = Employe::find($id);
        if(! $employe){
            throw new NotFoundHttpException('not find employe');
        }
        $start = date('Y-m-d', strtotime('monday this week'));
        $end = date('Y-m-d', strtotime('sunday this week'));
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
        $days = [
            $start
        ];
        $time = new \DateTime($start);
        while ($time->getTimestamp() < strtotime($end)){
            $time = $time->add(new \DateInterval('P1D'));
            $days[] = $time->format('Y-m-d');
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

        return view('admin.pm.statistics.graphic', [
            'statistics' => $statistics,
            'employe' => $employe,
        ]);
    }

    public function add($id, Request $request)
    {
        $find = Employe::find($id);
        if(! $find){
            throw new NotFoundHttpException('not find emplaye');
        }
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $day = date('Y-m-d', strtotime($input['date']));
            $tasks = $plans = [];
            if(! empty($input['task'])){
                foreach ($input['task'] as $task){
                    if(empty($task['link'])){
                        continue;
                    }
                    $task['link'] = trim($task['link']);
                    $plan = [
                        'link' => $task['link'],
                        'type' => $task['type'],
                        'time' => $task['time'],
                    ];
                    $key = md5($task['link']);
                    if(! empty($task['time'])){
                        $plans[$key] = $plan;
                    }
                    if(! empty($task['lead_time'])){
                        $item = [
                            'link' => $task['link'],
                            'type' => $task['type'],
                            'lead_time' => $task['lead_time'],
                        ];
                        $tasks[$key] = $item;
                    }
                }
            }
            $errors = [];
            foreach ($plans as $key => $planItem){
                $planTask = new PlanTask($planItem);
                $planTask->employe_id = $id;
                $planTask->pm_task_id = $planTask->convertLink($planTask->link);
                $planTask->date = $day;
                $pId = $planTask->getStatId();
                if(! $pId){
                    if (! $planTask->save()) {
                        $errors[] = 'not save '.json_encode($planItem);
                        continue;
                    }else{
                        $pId = $planTask->id;
                    }
                }

                if(! empty($tasks[$key])){
                    $statisticTask = new StatisticTask($tasks[$key]);
                    $statisticTask->employe_id = $id;
                    $statisticTask->plan_task_id = $pId;
                    $statisticTask->date = $day;
                    $statisticTask->pm_task_id = $statisticTask->convertLink($statisticTask->link);
                    unset($tasks[$key]);
                    $spId = $statisticTask->getStatId();
                    if(! $spId){
                        if(!$statisticTask->save()){
                            $errors[] = 'not save '.json_encode($tasks[$key]);
                        }
                    }
                }
            }
            foreach ($tasks as $taskItem){
                $statisticTask = new StatisticTask($taskItem);
                $statisticTask->employe_id = $id;
                $statisticTask->date = $day;
                $statisticTask->pm_task_id = $statisticTask->convertLink($statisticTask->link);
                $spId = $statisticTask->getStatId();
                if(! $spId){
                    if(! $statisticTask->save()){
                        $errors[] = 'not save '.json_encode($tasks[$key]);
                    }
                }

            }
            if(! empty($errors)){
                dd($errors);
            }
            return redirect('/admin/pm/statistic-tasks/graphic/'.$id);
        }
        return view('admin.pm.statistics.add', ['id' => $id, 'employe' => $find]);
    }
}
