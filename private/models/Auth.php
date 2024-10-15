<?php

class Auth
{
    public static function authenticate($row)
    {
        $_SESSION['USER'] = $row;
    }

    public static function logout()
    {
        if(isset($_SESSION['USER']))
        {
            unset($_SESSION['USER']);
        }
    }

    public static function logged_in()
    {
        if(isset($_SESSION['USER']))
        {
            return true;
        }
        return false;
    }

    public static function user()
    {
        if(isset($_SESSION['USER']))
        {
            return $_SESSION['USER']->firstname;
        }
        return false;
    }

    public static function __callStatic($method, $params)
    {
        $prop = strtolower(str_replace("get","",$method));
        if(isset($_SESSION['USER']->$prop))
        {
            return $_SESSION['USER']->$prop;
        }
        return 'Prefect of Discipline';
    }

    public static function switch_school($id)
    {
        if(isset($_SESSION['USER']) && in_array($_SESSION['USER']->rank, ['super_admin', 'admin', 'staff']))
        {
            $user = new User();
            $school = new School();

            if($row = $school->where('id', $id))
            {
                $row = $row[0];
                // Allow staff to view the information
                if ($_SESSION['USER']->rank == 'staff')
                {
                    // Return the school information without updating the user's school
                    return $row;
                }
                else
                {
                    // Update the user's school for admins and super admins
                    $arr['school_id'] = $row->school_id;

                    $user->update($_SESSION['USER']->id, $arr);

                    $_SESSION['USER']->school_id = $row->school_id;
                    $_SESSION['USER']->school_name = $row->school;

                    return true;
                }
            }
        }
        return false;
    }

    // Add these methods to check user roles
    public static function isAdmin()
    {
        return isset($_SESSION['USER']->rank) && $_SESSION['USER']->rank == 'admin';
    }

    public static function isSuperAdmin()
    {
        return isset($_SESSION['USER']->rank) && $_SESSION['USER']->rank == 'super_admin';
    }

    public static function isStudent()
    {
        return isset($_SESSION['USER']->rank) && $_SESSION['USER']->rank == 'student';
    }

    public static function isStaff()
    {
        return isset($_SESSION['USER']->rank) && $_SESSION['USER']->rank == 'staff';
    }

    public static function canPerformAction()
    {
        return isset($_SESSION['USER']->rank) && in_array($_SESSION['USER']->rank, ['admin', 'super_admin']);
    }
    public static function getUserId() {
        if (isset($_SESSION['USER'])) {
            return $_SESSION['USER']->user_id;
        }
        return false;
    }

    public static function checkStatus($row)
{
    if ($row->status == 'active') {
        return true;
    } else {
        return false;
    }
}
}