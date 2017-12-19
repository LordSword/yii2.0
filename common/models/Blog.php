<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ps_blog".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $content 内容
 * @property int $views 点击量
 * @property int $is_delete 是否删除 1未删除 2已删除
 * @property string $created_at 添加时间
 * @property string $updated_at 更新时间
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content', 'created_at', 'updated_at'], 'required'],
            [['id', 'views', 'is_delete'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'views' => 'Views',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
