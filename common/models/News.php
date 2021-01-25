<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $show_img
 * @property string $name
 * @property string $image
 * @property string $text
 * @property string $type
 * @property string $user_role
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $deleted
 * @property boolean $viewings
 *
 * @property Partner[] $partners
 * @property Department[] $departments
 * @property NewsLinks[] $newsLinks
 * @property NewsLinks $dir
 */
class News extends ActiveRecord
{

    /**
     * @var UploadedFile[]
     */
    public $files;
    public $prt_names;
    public $dep_names;

    const SCENARIO_SUPERADMIN = 'superadmin';
    const SCENARIO_PARTNER = 'partner';
    const SCENARIO_DIRECTOR = 'director';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [],
            self::SCENARIO_SUPERADMIN => ['text', 'name', 'prt_names', 'user_role', 'files', 'show_img', 'type'],
            self::SCENARIO_PARTNER => ['text', 'name', 'dep_names', 'files', 'show_img', 'type'],
            self::SCENARIO_DIRECTOR => ['text', 'name', 'files', 'show_img', 'type'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['prt_names', 'user_role'], 'required', 'on' => self::SCENARIO_SUPERADMIN],
            [['dep_names'], 'required', 'on' => self::SCENARIO_PARTNER],
            [['name'], 'required', 'on' => self::SCENARIO_DIRECTOR],
            [['text'], 'string'],
            [['show_img'], 'integer'],
            [['show_img'], 'default', 'value' => 1],
            [['name', 'type'], 'string', 'max' => 255],
            [['files'], 'file', 'maxFiles' => 10, 'extensions' => ['png', 'jpg', 'jpeg', 'pdf', 'zip', 'rar'], 'maxSize' => 1024 * 1024 * 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'type' => 'Type',
            'files' => 'File',
        ];
    }

    public function beforeValidate()
    {
        $this->files = UploadedFile::getInstances($this, 'files');
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        $this->user_role = strpos($this->user_role, "superadmin") === false ? "superadmin-{$this->user_role}" : $this->user_role;
        parent::afterValidate();
    }

    public function getPartners()
    {
        return $this->hasMany(Partner::class, ['id' => 'partner_id'])
            ->viaTable('department_to_news', ['news_id' => 'id']);
    }


    public function getDepartments()
    {
        return $this->hasMany(Department::class, ['web_id' => 'department_web_id'])
            ->viaTable('department_to_news', ['news_id' => 'id']);
    }


    public function getRoles()
    {
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        return $this->hasMany(DepartmentToNews::class, ['news_id' => 'id'])
            ->andWhere(["like", "roles", "%{$identity->role}%", false])
            ->andWhere(["department_web_id" => $identity->id_avdelinger,
                "partner_id" => $identity->partner->id]);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($this->files) {
            foreach ($this->files as $file) {
                $newsLinks = new NewsLinks([
                    "dir_name" => Yii::$app->request->post("dir_name"),
                    "file_extension" => $file->extension,
                    "news_id" => $this->id,
                    "file" => $file
                ]);
                $newsLinks->save();
            }
        }
        NewsLinks::updateAll(["dir_name" => Yii::$app->request->post("dir_name")], ["news_id" => $this->id]);

        if ($file_desc = Yii::$app->request->post("file_desc")) {
            $newsLinks = $this->newsLinks;
            foreach ($newsLinks as $key => $newsLink) {
                NewsLinks::updateAll(["file_desc" => $file_desc[$key]], ["id" => $newsLink->id]);
            }
        }


        $user = Yii::$app->user->identity;
        if ($user->hasRole("superadmin")) {
            $partners = Partner::find()->select(["id"])->where(["in", "name", $this->prt_names])->column();
            $departments = Department::find()->select(["web_id", "partner_id"])->where(["in", "partner_id", $partners])->all();
        } else if ($user->hasRole("partner")) {
            $departments = Department::find()->select(["web_id", "partner_id"])->where(["in", "short_name", $this->dep_names])->all();
            $this->user_role = "partner-director-broker";
        } else {
            $departments = Department::find()->select(["web_id", "partner_id"])->where(["web_id" => $user->department_id])->all();
            $this->user_role = "partner-director-broker";
        }

        if (!$this->isNewRecord) DepartmentToNews::deleteAll(["news_id" => $this->id]);

        $rows = [];

        foreach ($departments as $department)
            $rows[] = [
                "partner_id" => $department->partner_id,
                "news_id" => $this->id,
                "department_web_id" => $department->web_id,
                "roles" => $this->user_role
            ];

        Yii::$app->db->createCommand()
            ->batchInsert(DepartmentToNews::tableName(), [
                'partner_id', 'news_id', 'department_web_id', 'roles'
            ], $rows)->execute();

    }

    /**
     * @return ActiveQuery
     */
    public function getNewsLinks()
    {
        return $this->hasMany(NewsLinks::class, ["news_id" => "id"]);
    }

    /**
     * @return ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(NewsLinks::class, ["news_id" => "id"])
            ->where(["file_extension" => ["jpg", "png", "jpeg"]]);
    }

    /**
     * @return ActiveQuery
     */
    public function getDir()
    {
        return $this->hasOne(NewsLinks::class, ["news_id" => "id"])
            ->select(["dir_name"])->groupBy("dir_name");
    }


}