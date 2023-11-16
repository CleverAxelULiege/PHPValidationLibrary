<?php

namespace App\Database;

use App\Database\Parent\PostgresDatabase;

class ClinicDatabase extends PostgresDatabase{
    public function __construct()
    {
        parent::__construct("localhost", "clinic", "5432", "postgres", "admin");
    }
}