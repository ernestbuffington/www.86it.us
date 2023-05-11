<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 14.06.2017
 * Time: 14:18
 */

namespace an602\modules\content\tests\codeception\unit;


use an602\modules\content\components\ContentActiveRecord;
use an602\modules\content\permissions\ManageContent;
use an602\modules\post\models\Post;

class TestContent extends Post
{
    protected $managePermission = ManageContent::class;

    public function setManagePermission($managePermission = [])
    {
        $this->managePermission = $managePermission;
    }

    public function getContentName()
    {
        return 'TestContent';
    }
}
