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
use GibsonOS\Core\Wrapper\ModelWrapper;
use GibsonOS\Module\Tc\Enum\TrainStrategy;
use GibsonOS\Module\Tc\Form\TrackForm;
use GibsonOS\Module\Tc\Model\Track;
use GibsonOS\Module\Tc\Model\Track\System;
use GibsonOS\Module\Tc\Store\TrackStore;
use JsonException;
use MDO\Exception\RecordException;
use ReflectionException;

class TrackController extends AbstractController
{
    #[CheckPermission([Permission::READ])]
    public function get(
        #[GetModel]
        Track $track,
    ): AjaxResponse {
        return $this->returnSuccess($track);
    }

    #[CheckPermission([Permission::READ])]
    public function getList(
        #[GetStore]
        TrackStore $trackStore,
    ): AjaxResponse {
        return $trackStore->getAjaxResponse();
    }

    /**
     * @throws FormException
     */
    #[CheckPermission([Permission::MANAGE, Permission::WRITE])]
    public function getForm(
        TrackForm $trackForm,
        #[GetModel]
        ?Track $track = null,
    ): AjaxResponse {
        return $this->returnSuccess($trackForm->getForm(new ModelFormConfig($track)));
    }

    /**
     * @throws SaveError
     * @throws ViolationException
     * @throws JsonException
     * @throws RecordException
     * @throws ReflectionException
     */
    #[CheckPermission([Permission::MANAGE, Permission::WRITE])]
    public function post(
        ModelWrapper $modelWrapper,
        #[GetMappedModel]
        Track $track,
        array $trainSystems,
    ): AjaxResponse {
        $systems = [];

        foreach ($trainSystems as $system) {
            $systems[] = new System($modelWrapper)
                ->setStrategy(TrainStrategy::{$system})
            ;
        }

        $track->setSystems($systems);
        $modelWrapper->getModelManager()->save($track);

        return $this->returnSuccess($track);
    }

    /**
     * @throws JsonException
     * @throws DeleteError
     */
    #[CheckPermission([Permission::MANAGE, Permission::DELETE])]
    public function delete(
        ModelManager $modelManager,
        #[GetModel]
        Track $track,
    ): AjaxResponse {
        $modelManager->delete($track);

        return $this->returnSuccess();
    }
}
