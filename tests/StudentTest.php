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
            $enrollment = "8/25/2015";
            $test_student = new Student($name, $enrollment);
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
            $enrollment = "8/25/2015";
            $test_student = new Student($name, $enrollment);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_setEnrollDate()
        {
            //Arrange
            $name = "Joleen";
            $enrollment = "8/25/2015";
            $test_student = new Student($name, $enrollment);
            $new_date = "9/18/2015";

            //Act
            $test_student->setEnrollment($new_date);
            $result = $test_student->getEnrollment();

            //Assert
            $this->assertEquals($new_date, $result);
        }

        function test_getEnrollDate()
        {
            //Arrange
            $name = "Joleen";
            $enrollment = "8/25/2015";
            $test_student = new Student($name, $enrollment);

            //Act
            $result = $test_student->getEnrollment();

            //Assert
            $this->assertEquals($enrollment, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Joleen";
            $enrollment = "8/25/2015";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Joleen";
            $enrollment = "2015-09-18";
            $test_student = new Student($name, $enrollment);
            $test_student->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $id = null;
            $name = "Micah";
            $enrollment = "2015-08-28";
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "Phil";
            $enrollment2 = "2015-04-01";
            $test_student2 = new Student($name2, $enrollment2, $id);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function deleteAll()
        {
            //Arrange
            $id = null;
            $name = "Micah";
            $enrollment = "2015-01-01";
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "Phil";
            $enrollment2 = "2015-02-02";
            $test_student = new Student($name2, $enrollment2, $id);
            $test_student->save();

            //Act
            Student::deleteAll();
            $result = Student::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $id = null;
            $name = 'Micah';
            $enrollment = "2015-01-01";
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = 'Phil';
            $enrollment2 = '2015-02-02';
            $test_student2 = new Student($name2, $enrollment2, $id);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);
        }

        function testUpdate()
        {
            //Arrange
            $id = null;
            $name = "Micah";
            $enrollment = "2015-08-30";
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $field = "name";
            $new_name = "Phil";

            //Act
            $test_student->update($field, $new_name);

            //Assert
            $students = Student::getAll();
            $result = $students[0]->getName();
            $this->assertEquals($new_name, $result);
        }

        function testDeleteStudent()
        {
            //Arrange
            $id = null;
            $name = 'Micah';
            $enrollment = "2015-08-29";
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "Intro to History";
            $number = "HIST100";
            $test_course = new Course($name2, $number, $id);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->delete();

            //Assert
            $this->assertEquals([], $test_course->getStudents());
        }

        function testAddCourse()
        {
            //Arrange
            $id = null;
            $name = 'Micah';
            $enrollment = '2015-03-05';
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $course_name = 'Intro to History';
            $number = 'HIST100';
            $test_course = new Course($course_name, $number, $id);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }



    }

?>
