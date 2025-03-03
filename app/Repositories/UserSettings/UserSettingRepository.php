<?php

namespace App\Repositories\UserSettings;

use App\Models\UserSetting;
use App\Repositories\Base\BaseRepository;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Repositories\UserSettings\UserSettingRepository as Repository;

class UserSettingRepository extends Repository

{
    public function __construct(UserSetting $userSetting)
    {
        parent::__construct($userSetting);
    }



    

}
