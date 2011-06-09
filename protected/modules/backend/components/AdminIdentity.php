<?php
class AdminIdentity extends SyoIdentity
{

    public function authenticate()
	{
		  $employee=Employee::model()->findByAttributes(array('employee_email'=>$this->email));

        if($employee===null)
        {
            $this->errorCode=self::ERROR_EMAIL_INVALID;
        }
        else
        {

            if(!$employee->validatePassword($this->password))
            {
                 $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {
                 $this->id = $employee->employee_ID;
                 $this->name=$employee->employee_name;
                 $this->errorCode=self::ERROR_NONE;
            }
        }
        return !$this->errorCode;
	}
}


?>
