<?php

namespace App\Console\Commands;

use App\Models\Google\SheetConnector;
use App\Models\Google\SheetPmDay;
use App\Models\Pm\Employe;
use App\Models\Pm\PlanTask;
use App\Models\Pm\StatisticTask;
use Illuminate\Console\Command;

class ActualPmReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actual-pm:report {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Актуальный отчет за день';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $day = $this->argument('date');
        if(! $day){
            $day = date('Y-m-d');
        }else{
            $day = date('Y-m-d', strtotime($day));
        }
        $employes = Employe::all();
        $SheetConnector = new SheetConnector();
        $client = $SheetConnector->connect();
        $service = new \Google\Service\Sheets($client);
        $result = [];
        foreach ($employes as $employe){
            $get_range = $employe->name.'!A1:E20';
            $plans = PlanTask::where([['date',$day],['employe_id', $employe->id]])->get();
            $statistics = StatisticTask::where([['date',$day],['employe_id', $employe->id]])->get();
            $planTasks = $statisticTasks = [];
            foreach ($plans as $planTask){
                $planTasks[$planTask->pm_task_id] = $planTask;
            }
            foreach ($statistics as $task){
                $statisticTasks[$task->pm_task_id] = $task;
            }

            $spreadsheetId = env('PM_GOOGLE_SHEET_ID');
            $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
            $values = $response->getValues();
            $pmDay = new SheetPmDay($values);
            $tasks = $pmDay->tasks();
            foreach ($tasks as $id => $task){
               // dump($task);
                $link = $task['zadaca'];
                $lead_time = $task['zatracennoe-vremya'] ?? null;
                $lead_time = $this->convertTime($lead_time);
                $time = $task['vremya'] ?? 0;
                $time = $this->convertTime($time);
                $type = $task['tip'] ?? 'task';
                $comment = $task['kommentarii'] ?? '';
                if(empty($planTasks[$id])){
                    $add = [
                        'link' => $link,
                        'type'=> $type,
                        'time'=> $time,
                        'employe_id' => $employe->id,
                        'date' => $day,
                        'pm_task_id' => $id
                    ];
                    //dump($add);
                    $plan = PlanTask::create($add);
                    $pId = $plan->id;
                    $result[] = 'Create '.$link.' '.$employe->name.' - '.$pId;

                }else{
                    $plan = $planTasks[$id];
                    $pId = $plan->id;
                    if($time && $time != $plan->time){
                        $plan->time = $time;
                        $plan->save();
                        $result[] = 'Update '.$plan->link.' '.$employe->name;
                    }
                }
                if($lead_time > 0){
                    if(empty($statisticTasks[$id])){
                        $add = [
                            'link' => $link,
                            'type' => $type,
                            'lead_time' => $lead_time,
                            'description' => '',
                            'comment' => $comment,
                            'employe_id' => $employe->id,
                            'date' => $day,
                            'pm_task_id' => $id,
                            'plan_task_id' => $pId,
                        ];
                        $stat = StatisticTask::create($add);
                        $result[] = 'Create Result '.$link.' '.$employe->name.' - '.$stat->id;
                    }else{
                        $stat = $statisticTasks[$id];
                        if($lead_time != $stat->lead_time || $comment != $stat->comment){
                            $stat->lead_time = $lead_time;
                            $stat->comment = $comment;
                            $stat->save();
                            $result[] = 'Update Result '.$stat->link;
                        }
                    }
                }

            }
        }
        dump($result);
    }

    private function convertTime($time)
    {
       if($time){
           $time = trim($time);
           $time = str_replace(',','.',$time);
           $time = floatval($time);
           return $time;
       }
       return 0;
    }
}

