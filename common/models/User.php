<?php
namespace common\models;

use common\component\Util;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $password;
    public $role;
    public $imageFile;
    public $roles;
    public $from = "web";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dob', 'username', 'auth_key', 'password_hash', 'created_at', 'updated_at', 'role', 'roles', 'profile_picture', 'profile_picture_directory', 'password', 'gender', 'from'], 'safe'],
            [['username', 'password'], 'required', 'on' => 'create'],
            [['status', 'gender'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 200],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['created_at', 'updated_at', 'timezone'], 'string', 'max' => 50],
            [['mobile_no'], 'unique'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'profile_picture' => 'Profile Picture',
            'dob' => 'Dob',
            'email' => 'Email',
            'mobile_no' => 'Mobile No',
            'country' => 'Country',
            'timezone' => 'Timezone',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields["created_at"], $fields["updated_at"], $fields["status"], $fields["auth_key"],
            $fields["password_hash"], $fields["password_reset_token"]);

        if (Yii::$app->controller->action->uniqueId == "v1/tracker/users" ) {
            unset($fields["access_token"]);
        }

        //if (Yii::$app->controller->action->uniqueId == "v1/login/get-access-token" || Yii::$app->controller->action->uniqueId == "v1/login/index" || Yii::$app->controller->action->uniqueId == "v1/login/register" ) {
            unset($fields["first_name"], $fields["last_name"], $fields["dob"], $fields["mobile_no"], $fields["gender"], $fields["country"], $fields["timezone"], $fields["primary_address"]);
        //}

        /*$fields["pictures"] = function ($model) {
            $images = [];
            $images['normal'] = !empty($model->profile_picture) ? rtrim(Yii::$app->params['cdn_images_url'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . rtrim($model->profile_picture_directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $model->profile_picture : null;
            $images['thumb'] = !empty($model->profile_picture) ? rtrim(Yii::$app->params['cdn_images_url'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . rtrim($model->profile_picture_directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "thumbs" . DIRECTORY_SEPARATOR . $model->profile_picture : null;
            return $images;
        };*/

        unset($fields["profile_picture_directory"], $fields["profile_picture"]);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['and', ['status' => self::STATUS_ACTIVE], ['username' => $username]])->all();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates role
     *
     * @param string $role password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validateRole($role)
    {
        $authManager = $this->getAuthManager();
        return $authManager->checkAccess($this->id, $role);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns the full name of user by user identity
     * @return string full name of the user
     */
    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Util::clean(Yii::$app->security->generateRandomString(48));
        if (!empty(User::find()->where(["access_token" => $this->access_token])->one())) {
            $this->generateAccessToken();
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                //$this->sendEmail();
                $this->status = self::STATUS_ACTIVE;
                $this->generateAuthKey();
                $this->setPassword($this->password);
                $this->created_at = microtime(true);
                $this->generateAccessToken();
            }

            $this->updated_at = microtime(true);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $auth = Yii::$app->authManager;
        if ($this->role == "user" && !$auth->getAssignment("user", $this->getId())) {
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $this->getId());
        } else if ($this->role == "admin" && !$auth->getAssignment("admin", $this->getId())) {
            $authorRole = $auth->getRole('admin');
            $auth->assign($authorRole, $this->getId());
        }
    }
}
