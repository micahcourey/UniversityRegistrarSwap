<?php

    class Student
    {
        private $name;
        private $enroll_date;
        private $id;

        //Constructors
        function __construct($name, $enroll_date, $id = null)
        {
            $this->name = $name;
            $this->enroll_date = $enroll_date;
            $this->id = $id;
        }

        //Setters
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setEnrollDate($new_enroll)
        {
            $this->enroll_date = $new_enroll;
        }

        //Getters
        function getName()
        {
            return $this->name;
        }

        function getEnrollDate()
        {
            return $this->enroll_date;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enroll_date) VALUES ('{$this->getName()}', '{$this->getEnrollDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Return all students
        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enroll_date = $student['enroll_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enroll_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }


    }
?>
