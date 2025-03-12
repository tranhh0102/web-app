<?php

namespace App\Services;

use App\Models\Goal;

class GoalService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return Goal::where($conditions)->get();
    }
    public function insert($requestData = [])
    {
        return Goal::insert($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $goal = Goal::where($conditions)->firstOrFail();

        return $goal->save($requestData);
    }
    public function delete($conditions = [])
    {
        $goal = Goal::where($conditions)->firstOrFail();

        return $goal->delete();
    }
}