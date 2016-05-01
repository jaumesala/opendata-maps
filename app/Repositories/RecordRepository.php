<?php

namespace App\Repositories;

use App\Models\Record;

class RecordRepository
{
    public function getAll()
    {
        $roles = Record::all();

        return $roles;
    }

    public function getAllOrderedBy($column = 'created_at', $order = 'desc')
    {
        $roles = Record::orderBy($column, $order)->get();

        return $roles;
    }
}