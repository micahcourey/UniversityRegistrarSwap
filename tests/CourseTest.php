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

        //Save function
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

        function testGetAll()
        {
            //Arrange
            $id = null;
            $name = "Intro to Math";
            $number = "MATH100";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $name2 = "Intro to History";
            $number2 = "HIST100";
            $test_course2 = new Course($name2, $number2, $id);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $id = null;
            $name = "Intro to Math";
            $number = "MATH100";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $name2 = "Intro to History";
            $number2 = "HIST101";
            $test_course2 = new Course($name2, $number2, $id);
            $test_course2->save();

            //Act
            Course::deleteAll();

            //Assert
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $id = null;
            $name = "Intro to History";
            $number = "HIST101";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $name2 = "Intro to Math";
            $number2 = "MATH101";
            $test_course2 = new Course($name2, $number2, $id);
            $test_course2->save();

            //Act
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        function testAddStudent()
        {
            //Arrange
            $id = null;
            $name = "Intro to Math";
            $number = "MATH100";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $name2 = "Micah";
            $id2 = null;
            $enrollment_date = "2015-09-13";
            $test_student = new Student($name2, $enrollment_date, $id2);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function testUpdate()
        {
            //Arrange
            $id = null;
            $name = "Intro to Math";
            $number = "MATH400";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $field = "course_name";
            $new_value = "MATH101";

            //Act
            $test_course->update($field, $new_value);

            //Assert
            $courses = Course::getAll();
            $result = $courses[0]->getCourseName();
            $this->assertEquals($new_value, $result);
        }

        //test/method for update

        //test/method for deleteCourse


        function testGetStudents()
        {
            //Arrange
            $id = null;
            $name = "Intro to Math";
            $number = "MATH100";
            $test_course = new Course($name, $number, $id);
            $test_course->save();

            $name2 = "Micah";
            $id2 = null;
            $enrollment_date = "2015-09-13";
            $test_student = new Student($name2, $enrollment_date, $id2);
            $test_student->save();

            $name3 = "Phil";
            $id3 = null;
            $enrollment_date2 = "2015-09-03";
            $test_student2 = new Student($name3, $enrollment_date2, $id3);
            $test_student2->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }
    }


?>
