<?php

namespace App\Services;

interface BaseServiceInterface {
    public function get($conditions = []);
    public function insert($requestData = []);
    public function update($conditions = [], $requestData = []);
    public function delete($conditions = []);
}