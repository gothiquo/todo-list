<?php

namespace TaskManagement\Task\Persistence;

use TaskManagement\Task\Model\Task;
use TaskManagement\User\Model\User;

class TaskRepository
{
    /**
     * @var Task
     */
    protected $model;

    /**
     * TaskRepository constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * @param int/string $id
     * @return Task
     * @throws \Exception
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param User $user
     * @return Task[]/Collection
     */
    public function findAllByUser(User $user)
    {
        return $this->model->newQuery()
            ->where('user_id', $user->getId())
            ->get()->all();
    }

    /**
     * @return Task[]/Collection
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * @return Task[]/Collection
     */
    public function findAllPaginated($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function store(array $data)
    {
        switch (strtolower($data['request']))  {
            case 'post':
                $this->model->create($data);
                break;

            case 'put':
                $task = $this->findById($data['id']);
                $task->title = $data['title'];
                $task->save();
                break;
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->findById($id)->delete();
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function deleteAllByUser(User $user)
    {
        $tasks = $this->findAllByUser($user);
        foreach ($tasks as $task) {
            $this->delete($task);
        }
    }
}