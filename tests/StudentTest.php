<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=registry_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function test_setName()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "8/25/2015";
            $test_student = new Student($name, $enroll_date);
            $new_name = "Babs";

            //Act
            $test_student->setName($new_name);
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_getName()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "8/25/2015";
            $test_student = new Student($name, $enroll_date);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_setEnrollDate()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "8/25/2015";
            $test_student = new Student($name, $enroll_date);
            $new_date = "9/18/2015";

            //Act
            $test_student->setEnrollDate($new_date);
            $result = $test_student->getEnrollDate();

            //Assert
            $this->assertEquals($new_date, $result);
        }

        function test_getEnrollDate()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "8/25/2015";
            $test_student = new Student($name, $enroll_date);

            //Act
            $result = $test_student->getEnrollDate();

            //Assert
            $this->assertEquals($enroll_date, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "8/25/2015";
            $id = 1;
            $test_student = new Student($name, $enroll_date, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Joleen";
            $enroll_date = "2015-09-18";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals($test_student, $result[0]);
        }

    }

?>
