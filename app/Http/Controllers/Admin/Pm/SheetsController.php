<?php
namespace App\Http\Controllers\Admin\Pm;

use App\Http\Controllers\Controller;
use App\Models\Google\SheetConnector;
use App\Models\Google\SheetPmDay;
use App\Models\Pm\Employe;
use App\Models\Pm\PlanTask;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SheetsController extends Controller
{
    public function tasks($id = null)
    {
        $employe = Employe::find($id);
        if(! $employe){
            throw new NotFoundHttpException('not find employe');
        }
        $SheetConnector = new SheetConnector();
        $client = $SheetConnector->connect();
        $service = new \Google\Service\Sheets($client);
        $get_range = $employe->name.'!A1:D20';
        $spreadsheetId = env('PM_GOOGLE_SHEET_ID');
        $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
        $values = $response->getValues();
        $pmDay = new SheetPmDay($values);

        return response()->json([
            'tasks' => $pmDay->tasks(),
        ]);
    }

    public function users()
    {
        $employes = Employe::all();
        $SheetConnector = new SheetConnector();
        $client = $SheetConnector->connect();
        $service = new \Google\Service\Sheets($client);
        $result = [
            'users' => [],
            'tasks' => [],
        ];
        $today = date('Y-m-d');
        foreach ($employes as $employe){
            $get_range = $employe->name.'!A1:D20';
            $plans = PlanTask::where('date',$today)->get();
            $planTasks = [];
            foreach ($plans as $planTask){
                $planTasks[$planTask->pm_task_id] = $planTask;
            }

            $spreadsheetId = env('PM_GOOGLE_SHEET_ID');
            $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
            $values = $response->getValues();
            $pmDay = new SheetPmDay($values);
            $tasks = $pmDay->tasks();
            foreach ($tasks as $id => $task){
                if(empty($planTasks[$id])){
                    $add = [
                        'link' => $task['zadaca'],
                        'type'=> $task['tip'] ?? 'task',
                        'time'=> $task['vremya'] ? intval($task['vremya']) : 0,
                        'employe_id' => $employe->id,
                        'date' => $today,
                        'pm_task_id' => $id
                    ];
                    PlanTask::create($add);
                }
                $result['tasks'][$id] = $task;
            }
            $result['users'][$employe->id] = [
                'user' => $employe,
                'tasks' => $tasks,
            ];
        }
        return response()->json($result);
    }

    public function pm()
    {
        $employes = Employe::all();
        $result = [
            'users' => [],
            'tasks' => [],
        ];
        $today = date('Y-m-d');
        foreach ($employes as $employe){
            $plans = PlanTask::where([['date',$today], ['employe_id', $employe->id]])->with('owner')->get();
            $planTasks = [];
            foreach ($plans as $planTask){
                $planTasks[$planTask->pm_task_id] = $planTask;
                $result['tasks'][$planTask->pm_task_id] = $planTask;
            }
            $result['users'][$employe->id] = [
                'user' => $employe,
                'count' => count($planTasks),
                'tasks' => $planTasks,
            ];
        }
        return response()->json($result);
    }


    public function index($spreadsheetId = null)
    {


    }

    public function add($id, Request $request)
    {
        $employe = Employe::find($id);
        if(! $employe){
            throw new NotFoundHttpException('not find employe');
        }
        $request->validate([
            'link' => 'required|url',
            'pm_task_id' => 'required',
            'type' => 'required',
            'time' => 'required',
        ]);
        $input = $request->collect()->all();
        $today = date('Y-m-d');
        $input['employe_id'] = $employe->id;
        $input['date'] = $today;
        $input['time'] = floatval($input['time']);
        $pm_task_id = $input['pm_task_id'];
        $plan = PlanTask::where([['date',$today], ['employe_id', $employe->id], ['pm_task_id', $input['pm_task_id']]])->first();
        $result = [
           // 'post' => $input
        ];
        if(empty($plan)){
            $SheetConnector = new SheetConnector();
            $client = $SheetConnector->connect();
            $service = new \Google\Service\Sheets($client);
            $spreadsheetId = env('PM_GOOGLE_SHEET_ID');
            $get_range = $employe->name.'!A1:D20';
            $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
            $values = $response->getValues();
            $pmDay = new SheetPmDay($values);
            $tasks = $pmDay->tasks();
            if(empty($tasks[$pm_task_id])){
                $last = $pmDay->lastRow();
                $last++;
                $update_range = $employe->name."!A{$last}:D{$last}";
                $values = [
                    [
                        $input['link'],
                        $input['type'],
                        $input['time'],
                        ''
                    ]
                ];
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => $values
                ]);
                $params = [
                    'valueInputOption' => 'RAW',
                ];
                $result['add'] = $values;
                $result['update_range'] = $update_range;
                $result['sheet'] = $service->spreadsheets_values->update($spreadsheetId, $update_range, $body, $params);
            }
            if($plan = PlanTask::create($input)){
                $result['id'] = $plan->id;
            }
        }else{
            $result['plan'] = $plan;
        }

        return response()->json($result);
    }
}
