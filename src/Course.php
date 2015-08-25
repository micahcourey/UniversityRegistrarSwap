<?php

    class Course
    {
        private $course_name;
        private $course_number;
        private $id;

        function __construct($course_name, $course_number, $id = null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        //Setters
        function setCourseName($new_course_name)
        {
            $this->course_name = (string) $new_course_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = $new_course_number;
        }

        //Getters
        function getCourseName()
        {
            return $this->course_name;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getStudents()
        {
                $results = $GLOBALS['DB']->query(
                    "SELECT students.* FROM
                         courses JOIN students_courses ON (courses.id = students_courses.course_id)
                         JOIN students ON (students_courses.student_id = students.id)
                         WHERE courses.id = {$this->getId()};");
                $students = array();
                foreach ($results as $result) {
                    $id = $result['id'];
                    $name = $result['name'];
                    $enrollment = $result['enrollment'];
                    $new_student = new Student($name, $enrollment, $id);
                    array_push($students, $new_student);
                }
                return $students;
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id) VALUES ({$student->getId()}, {$this->getId()});");
        }

        function update($field, $value)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET {$field} = '{$value}' WHERE id = {$this->getId()};");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE ID = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE course_id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $course_name = $course['course_name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach ($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }
    }




?>
