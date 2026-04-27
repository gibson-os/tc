<?php
declare(strict_types=1);

namespace Tc\Controller;

use GibsonOS\Core\Attribute\CheckPermission;
use GibsonOS\Core\Controller\AbstractController;
use GibsonOS\Core\Enum\Permission;
use GibsonOS\Core\Service\Response\AjaxResponse;

class TrackController extends AbstractController
{
    #[CheckPermission([Permission::READ])]
    public function get(): AjaxResponse
    {
        return $this->returnSuccess();
    }

    #[CheckPermission([Permission::READ])]
    public function getList(): AjaxResponse
    {
        return $this->returnSuccess();
    }

    #[CheckPermission([Permission::MANAGE, Permission::WRITE])]
    public function getForm(): AjaxResponse
    {
        return $this->returnSuccess();
    }

    #[CheckPermission([Permission::MANAGE, Permission::WRITE])]
    public function post(): AjaxResponse
    {
        return $this->returnSuccess();
    }

    #[CheckPermission([Permission::MANAGE, Permission::DELETE])]
    public function delete(): AjaxResponse
    {
        return $this->returnSuccess();
    }
}
