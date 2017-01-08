<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 * @property  login_role
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $role = 'user';

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Email or Mobile Number and password are both required
            [['username', 'password', 'role'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // Email or mobile number role is validated by validateRole()
            ['username', 'validateRole'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels(){
        return [
            'username' => "User name"
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $users = $this->getUser();
            $isValid = false;
            foreach($users as $user) {
                if ($user && $user->validatePassword($this->password)) {
                    $isValid = true;
                }
            }
            if(!$isValid)
                $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    /**
     * Validate the user has a role
     * This method serves as the inline validation for user role.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateRole($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $users = $this->getUser();
            $isValid = false;
            foreach($users as $user) {
                if ($user && $user->validateRole($this->role)) {
                    $isValid = true;
                }
            }

            if(!$isValid)
                $this->addError($attribute, 'You don\'t have enough rights to login here!!.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @param string $role the role to identify to login
     * @return bool whether the user is logged in successfully
     */
    public function login($role = 'user')
    {
        $this->role = $role;
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function loginByApi()
    {
        if ($this->validate()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserId(){
        $users = $this->getUser();
        foreach($users as $user) {
            if($user->validateRole($this->role)) {
                return $user->id;
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
