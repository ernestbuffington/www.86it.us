<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\admin\models;

use an602\modules\user\models\Invite;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * PendingRegistrationSearch
 *
 * @author buddha
 */
class PendingRegistrationSearch extends Invite
{
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['originator.username']);
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email', 'created_at', 'originator.username',  'source', 'language'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $result = parent::attributeLabels();
        $result['originator.username'] = Yii::t('AdminModule.base', 'Invited by');
        return $result;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $query = self::find()->joinWith(['originator']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'email',
                'created_at',
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'id', $this->id]);
        $query->andFilterWhere(['like', 'username', $this->getAttribute('originator.username')]);
        $query->andFilterWhere(['like', 'user_invite.email', $this->email]);
        $query->andFilterWhere(['like', 'user_invite.language', $this->language]);
        $query->andFilterWhere(['source' => $this->source]);

        return $dataProvider;
    }
}
