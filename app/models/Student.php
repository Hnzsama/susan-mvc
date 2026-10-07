<?php
// app/models/Student.php - Model Siswa dengan Base Model ORM

class Student extends Model {
    protected static $table = 'student';
    protected static $primaryKey = 'id';
}