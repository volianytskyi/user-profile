<?php
/**
 * Users: volyanytsky
 * Date: 20.12.17
 * Time: 19:32
 */

namespace StalkerPortal\ApiV1\Resources;

use StalkerPortal\ApiV1\Exceptions\StalkerPortalException;
use StalkerPortal\ApiV1\Interfaces\Account as AccountInterface;

class Users extends BaseUsers
{
    public function getResource()
    {
        return 'users';
    }

    public function isLoginUnique($login)
    {
        return $this->isMacUnique($login);
    }

    public function updateUserByLogin(AccountInterface $user)
    {
        $data = [];

        $data['password'] = $user->getPassword();
        $data['stb_mac'] = $user->getMac();
        $data['full_name'] = $user->getFullName();
        $data['account_number'] = $user->getAccountNumber();
        $data['tariff_plan'] = $user->getTariffPlanExternalId();
        $data['status'] = $user->getStatus();
        $data['comment'] = $user->getComment();
        $data['end_date'] = $user->getExpireDate();
        $data['account_balance'] = $user->getAccountBalance();

        return $this->put($user->getLogin(), $data);
    }

}
