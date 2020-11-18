<?php

namespace App\Models;

use App\Database;
use PDO;
use Illuminate\Support\Collection;

class Student
{
    private PDO $pdo;

    private string $table = 'students';

    private Collection $columns;

    public function __construct()
    {
        $this->pdo = (Database::get_instance())->connect();
        $this->columns = Collection::make(["id", "name", "email", "phone_number", "address", "entry_points"]);
    }

    public function insert(array $student_details): bool
    {
        $student_details = Collection::make($student_details);
        $columns_string = $student_details->keys()->implode(',');
        $values_string = $student_details->keys()->map(fn ($key) => ":{$key}")->implode(',');

        $query = "INSERT into {$this->table}({$columns_string}) VALUES({$values_string})";
        $statement = $this->pdo->prepare($query);
        $input_args = $student_details->mapWithKeys(fn ($value, $column) => [":{$column}" => $value])->all();

        return $statement->execute($input_args);
    }

    public function get_all_students()
    {
        $statement = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC;");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_admission(string $admission_number) 
    {
        $columns_string = $this->columns->implode(',');
        $statement = $this->pdo->prepare("SELECT {$columns_string} FROM {$this->table} WHERE id = :admission_number LIMIT 1;");
        $statement->execute([":admission_number" => $admission_number]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
