<?php

    class Student
    {
        private $name;
        private $enrollment;
        private $id;

        //Constructors
        function __construct($name, $enrollment, $id = null)
        {
            $this->name = $name;
            $this->enrollment = $enrollment;
            $this->id = $id;
        }

        //Setters
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setEnrollment($new_enroll)
        {
            $this->enrollment = $new_enroll;
        }

        //Getters
        function getName()
        {
            return $this->name;
        }

        function getEnrollment()
        {
            return $this->enrollment;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment) VALUES ('{$this->getName()}', '{$this->getEnrollment()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($field, $new_value)
        {
            $GLOBALS['DB']->exec("UPDATE students SET {$field} = '{$new_value}' WHERE id = {$this->getId()};");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getId()};");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id) VALUES ({$this->getId()}, {$course->getId()});");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT course_id FROM students_courses WHERE student_id = {$this->getId()};");
            $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $courses = array();
            foreach($course_ids as $id) {
                $course_id = $id['course_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$course_id};");
                $returned_course = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_course[0]['course_name'];
                $number = $returned_course[0]['course_number'];
                $id = $returned_course[0]['id'];
                $new_course = new Course($name, $number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        //Return all students
        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enrollment = $student['enrollment'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach ($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

    }
?>
