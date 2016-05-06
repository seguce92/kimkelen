<?php

/**
 * ExaminationSubject filter form.
 *
 * @package    sistema de alumnos
 * @subpackage filter
 * @author     Your name here
 */
class ExaminationSubjectFormFilter extends BaseExaminationSubjectFormFilter
{
  public function configure()
  {
    unset($this['examination_id'], $this['career_subject_school_year_id'],  $this['examination_subject_teacher_list']);

    $this->setWidget('subject_name', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('subject_name', new sfValidatorSchemaFilter('text', new sfValidatorString(array('required' => false))));
/*
    $this->setWidget('year', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('year', new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))));
*/
    $this->setWidget('student', new dcWidgetFormPropelJQuerySearch(array('model' => 'Person', 'column' => array('lastname', 'firstname'), 'peer_method' => 'doSelectStudent')));
    $this->setValidator('student', new sfValidatorPropelChoice(array('required' => false, 'model' => 'Person', 'column' => 'id')));

    $this->setWidget('career_school_year', new sfWidgetFormPropelChoice(array('model' => 'CareerSchoolYear','criteria' => $this->getCareersCriteria(), 'add_empty' => true)));
    $this->setValidator('career_school_year', new sfValidatorPropelChoice(array('required' => false, 'model' => 'CareerSchoolYear', 'column' => 'id')));
  
  }

  public static function getCareersCriteria()
  {
    $criteria = new Criteria();
    $school_year = SchoolYearPeer::retrieveCurrent();

    $criteria->add(CareerSchoolYearPeer::SCHOOL_YEAR_ID, $school_year->getId());

    return $criteria;
  }

  public function getFields()
  {
    return array(
      'subject_name' => 'Text', 
      /*'year' => 'Number',*/ 
      'is_closed' => 'Boolean', 
      'student' => 'ForeignKey',
      'career_school_year' => 'ForeignKey',
      );

  }

  public function addCareerSchoolYearColumnCriteria($criteria, $field, $value)
  {
    if ($value !== null)
    {
      $criteria->addJoin(CoursePeer::ID, CourseSubjectPeer::COURSE_ID, Criteria::INNER_JOIN);
      $criteria->addJoin(CourseSubjectPeer::CAREER_SUBJECT_SCHOOL_YEAR_ID, CareerSubjectSchoolYearPeer::ID, Criteria::INNER_JOIN);
      $criteria->add(CareerSubjectSchoolYearPeer::CAREER_SCHOOL_YEAR_ID, $value);
    }
   
    $criteria->setDistinct(CoursePeer::ID); die(var_dump($criteria));
  }


  public function addSubjectNameColumnCriteria($criteria, $field, $value)
  {
    $value = trim($value);
    if ($value != '')
    {
      $value = "%$value%";

      $criteria->setIgnoreCase(true);
      $criteria->addJoin(PersonalPeer::PERSON_ID, PersonPeer::ID);
      $criterion = $criteria->getNewCriterion(PersonPeer::FIRSTNAME, $value, Criteria::LIKE);
      $criterion->addOr($criteria->getNewCriterion(PersonPeer::LASTNAME, $value, Criteria::LIKE));
      $criterion->addOr($criteria->getNewCriterion(PersonPeer::IDENTIFICATION_NUMBER, $value, Criteria::LIKE));
      $criteria->add($criterion);
    }
  }
/*
  public function addYearColumnCriteria($criteria, $field, $value)
  {
    if (! is_null($value['text']))
    {
      $criteria->addJoin(ExaminationSubjectPeer::CAREER_SUBJECT_SCHOOL_YEAR_ID, ExaminationSubjectPeer::ID);
      $criteria->addJoin(CareerSubjectSchoolYearPeer::CAREER_SUBJECT_ID, CareerSubjectPeer::ID);
      $criteria->add(CareerSubjectPeer::YEAR, $value['text']);
      
    }
  }
*/
  public function addStudentColumnCriteria(Criteria $criteria, $field, $value)
  {
    $criteria->addJoin(CourseSubjectStudentExaminationPeer::EXAMINATION_SUBJECT_ID, ExaminationSubjectPeer::ID);
    $criteria->addJoin(CourseSubjectStudentExaminationPeer::COURSE_SUBJECT_STUDENT_ID, CourseSubjectStudentPeer::ID);
    $criteria->addJoin(CourseSubjectStudentPeer::STUDENT_ID, StudentPeer::ID);
    $criteria->addJoin(StudentPeer::PERSON_ID, PersonPeer::ID);
    $criteria->add(PersonPeer::ID, $value);

  }


}
