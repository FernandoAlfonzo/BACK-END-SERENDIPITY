<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Person;
use App\Models\User;

class Students
{
    public function get()
    {
        $students = Student::join('persons', 'persons.id', 'students.id_person')
            ->join('users', 'users.id_person', 'persons.id')
            ->where('students.is_active', 1)
            ->where('students.status', 'ALUMNO')
            ->select('users.id as userId', 'persons.id as personId', 'students.id as studentId', 'persons.name as name', 'persons.last_father_name as lastFName', 'persons.last_mother_name as lastMName')
            ->orderBy('students.id', 'asc')
            ->get();

        foreach ($students as $student) {
            $studentsList[$student->userId] = $student->name . ' ' . $student->lastFName . ' ' . $student->lastMName;
        }
        return $studentsList;
    }
}