<?php
require_once 'Course.php';

class User
{
    private $u_first;
    private $u_last;
    private $u_email;
    private $u_role;
    private $u_id;
    private $car;

    /**
     * User constructor.
     * @param $u_first
     * @param $u_last
     * @param $u_email
     * @param $u_role
     * @param $u_id
     * @param $car
     */
    public function __construct($u_first, $u_last, $u_email, $u_role, $u_id, $car)
    {
        $this->u_first = $u_first;
        $this->u_last = $u_last;
        $this->u_email = $u_email;
        $this->u_role = $u_role;
        $this->u_id = $u_id;
        $this->car = $car;
    }

    /**
     * @return mixed
     */
    public function getUFirst()
    {
        return $this->u_first;
    }

    /**
     * @param mixed $u_first
     */
    public function setUFirst($u_first)
    {
        $this->u_first = $u_first;
    }

    /**
     * @return mixed
     */
    public function getULast()
    {
        return $this->u_last;
    }

    /**
     * @param mixed $u_last
     */
    public function setULast($u_last)
    {
        $this->u_last = $u_last;
    }

    /**
     * @return mixed
     */
    public function getUEmail()
    {
        return $this->u_email;
    }

    /**
     * @param mixed $u_email
     */
    public function setUEmail($u_email)
    {
        $this->u_email = $u_email;
    }

    /**
     * @return mixed
     */
    public function getURole()
    {
        return $this->u_role;
    }

    /**
     * @param mixed $u_role
     */
    public function setURole($u_role)
    {
        $this->u_role = $u_role;
    }

    /**
     * @return mixed
     */
    public function getUId()
    {
        return $this->u_id;
    }

    /**
     * @param mixed $u_id
     */
    public function setUId($u_id)
    {
        $this->u_id = $u_id;
    }

    /**
     * @return mixed
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $car
     */
    public function setCar($car)
    {
        $this->car = $car;
    }
}
