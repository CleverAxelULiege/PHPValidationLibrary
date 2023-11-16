<?php

namespace App\Database\Parent;

class PostgresDatabase extends Database{
    public function __construct(string $host, string $dbName, string $port, string $user, string $password)
    {
        $this->driver = "pgsql";
        parent::__construct($host, $dbName, $port, $user, $password);
    }

    public function getTables(): array
    {
        return array_map(function($table){
            return $table->tablename;
        }, $this->run("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema';")->fetchAll());
    }

    public function getColumnsFromTable(string $table): array
    {
        return array_map(function($column){
            return $column->column_name;
        }, $this->run("SELECT column_name FROM information_schema.columns WHERE table_name = :table;", ["table" => $table])->fetchAll());
    }
}