<?php

namespace TaskManagement\Task\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TaskManagement\Application\Errors\ResponseError;
use TaskManagement\Application\ResponseSuccess;
use TaskManagement\Task\Persistence\TaskRepository;
use Response;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->taskRepository->findAllPaginated(4);
        return Response::json(['status' => 'ok', 'tasks' => $tasks, 'message' => ''], ResponseSuccess::STATUS_OK);
    }

    /**
     * Store a newly created Task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ['request' => $request->method()];
        $data = array_merge($data, $request->all());
        try{
            $this->taskRepository->store($data);
            return Response::json(['status' => 'ok', 'message' => ''], ResponseSuccess::STATUS_CREATED);
        }
        catch (\Exception $e) {
            return Response::json(['status' => 'error', 'message' => 'Error when creating the task'], ResponseError::STATUS_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified Task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $task = $this->taskRepository->findById($id);
            return Response::json(['status' => 'ok', 'task' => $task, 'message' => ''], ResponseSuccess::STATUS_OK);
        }
        catch (\Exception $e) {
            return Response::json(['status' => 'error', 'message' => 'Error when searching the task'], ResponseError::STATUS_RESOURCE_NOT_FOUND);
        }
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->taskRepository->findById($id)->delete();
            return Response::json(['status' => 'ok', 'message' => 'Task deleted successfully'], ResponseSuccess::STATUS_NO_CONTENT);
        }
        catch (\Exception $e) {
            return Response::json(['status' => 'error', 'message' => 'Error when deleting the task'], ResponseError::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
