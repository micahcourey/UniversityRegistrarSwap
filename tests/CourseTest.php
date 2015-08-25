<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=registry_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
        }

        function test_setCourseName()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $test_course = new Course($course_name, $course_number);
            $new_name = "Erotica Film";

            //Act
            $test_course->setCourseName($new_name);
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_getCourseName()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $test_course = new Course($course_name, $course_number);

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($course_name, $result);
        }

        function test_setCourseNumber()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $test_course = new Course($course_name, $course_number);
            $new_number = "ENG204";

            //Act
            $test_course->setCourseNumber($new_number);
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($new_number, $result);
        }

        function test_getCourseNumber()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $test_course = new Course($course_name, $course_number);

            //Act
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($course_number, $result);
        }

        function test_getId()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $course_name = "Monster Literature";
            $course_number = "ENG304";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }
    }


?>
