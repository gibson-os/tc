<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Controller;

use GibsonOS\Core\Attribute\CheckPermission;
use GibsonOS\Core\Attribute\GetMappedModel;
use GibsonOS\Core\Attribute\GetModel;
use GibsonOS\Core\Attribute\GetStore;
use GibsonOS\Core\Controller\AbstractController;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Enum\Permission;
use GibsonOS\Core\Exception\FormException;
use GibsonOS\Core\Exception\Model\DeleteError;
use GibsonOS\Core\Exception\Model\SaveError;
use GibsonOS\Core\Exception\ViolationException;
use GibsonOS\Core\Manager\ModelManager;
use GibsonOS\Core\Service\Response\AjaxResponse;
use GibsonOS\Module\Tc\Form\TrainControlForm;
use GibsonOS\Module\Tc\Form\TrainForm;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Store\TrainStore;
use JsonException;
use MDO\Exception\RecordException;
use ReflectionException;

class TrainController extends AbstractController
{
    #[CheckPermission([Permission::READ])]
    public function get(
        #[GetModel]
        Train $train,
    ): AjaxResponse {
        return $this->returnSuccess($train);
    }

    #[CheckPermission([Permission::READ])]
    public function getList(
        #[GetStore]
        TrainStore $trainStore,
    ): AjaxResponse {
        return $trainStore->getAjaxResponse();
    }

    /**
     * @throws FormException
     */
    #[CheckPermission([Permission::WRITE, Permission::MANAGE])]
    public function getForm(
        TrainForm $trainForm,
        #[GetModel]
        ?Train $train = null,
    ): AjaxResponse {
        return $this->returnSuccess($trainForm->getForm(new ModelFormConfig($train)));
    }

    #[CheckPermission([Permission::WRITE])]
    public function getControlForm(
        TrainControlForm $trainControlForm,
        #[GetModel]
        Train $train,
    ): AjaxResponse {
        return $this->returnSuccess($trainControlForm->getForm(new ModelFormConfig($train)));
    }

    /**
     * @throws JsonException
     * @throws RecordException
     * @throws ReflectionException
     * @throws SaveError
     * @throws ViolationException
     */
    #[CheckPermission([Permission::WRITE, Permission::MANAGE])]
    public function post(
        ModelManager $modelManager,
        #[GetMappedModel]
        Train $train,
    ): AjaxResponse {
        $modelManager->saveWithoutChildren($train);

        return $this->returnSuccess($train);
    }

    /**
     * @throws SaveError
     * @throws ViolationException
     * @throws JsonException
     * @throws RecordException
     * @throws ReflectionException
     * @throws DeleteError
     */
    #[CheckPermission([Permission::DELETE, Permission::MANAGE])]
    public function delete(
        ModelManager $modelManager,
        #[GetModel]
        Train $train,
    ): AjaxResponse {
        $modelManager->delete($train);

        return $this->returnSuccess($train);
    }
}
