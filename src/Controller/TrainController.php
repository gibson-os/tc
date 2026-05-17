<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Controller;

use GibsonOS\Core\Attribute\AlwaysAjaxResponse;
use GibsonOS\Core\Attribute\CheckPermission;
use GibsonOS\Core\Attribute\GetMappedModel;
use GibsonOS\Core\Attribute\GetModel;
use GibsonOS\Core\Attribute\GetSetting;
use GibsonOS\Core\Attribute\GetStore;
use GibsonOS\Core\Controller\AbstractController;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Enum\Permission;
use GibsonOS\Core\Exception\CreateError;
use GibsonOS\Core\Exception\DeleteError;
use GibsonOS\Core\Exception\FileNotFound;
use GibsonOS\Core\Exception\FormException;
use GibsonOS\Core\Exception\GetError;
use GibsonOS\Core\Exception\Image\CreateError as ImageCreateError;
use GibsonOS\Core\Exception\Image\LoadError;
use GibsonOS\Core\Exception\Model\DeleteError as ModelDeleteError;
use GibsonOS\Core\Exception\Model\SaveError;
use GibsonOS\Core\Exception\SetError;
use GibsonOS\Core\Exception\ViolationException;
use GibsonOS\Core\Manager\ModelManager;
use GibsonOS\Core\Model\Setting;
use GibsonOS\Core\Service\DirService;
use GibsonOS\Core\Service\FileService;
use GibsonOS\Core\Service\Image\ManipulateService;
use GibsonOS\Core\Service\Response\AjaxResponse;
use GibsonOS\Core\Service\Response\ImageResponse;
use GibsonOS\Module\Tc\Form\TrainControlForm;
use GibsonOS\Module\Tc\Form\TrainForm;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;
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
        return $this->returnSuccess($trainControlForm->getForm($train));
    }

    /**
     * @throws FileNotFound
     * @throws JsonException
     * @throws RecordException
     * @throws ReflectionException
     * @throws SaveError
     * @throws ViolationException
     * @throws CreateError
     * @throws DeleteError
     * @throws GetError
     * @throws SetError
     */
    #[CheckPermission([Permission::WRITE, Permission::MANAGE])]
    #[AlwaysAjaxResponse]
    public function post(
        DirService $dirService,
        FileService $fileService,
        TrainProvider $trainProvider,
        ModelManager $modelManager,
        #[GetSetting('imagePath', 'tc')]
        Setting $imagePath,
        #[GetMappedModel]
        Train $train,
        #[GetModel]
        ?Train $originalTrain,
        ?string $action,
        array $image = [],
    ): AjaxResponse {
        $strategy = $trainProvider->getStrategy($train);
        $strategy->send($train, $originalTrain, $action);

        if (isset($image['tmp_name'])) {
            $fileService->move(
                $image['tmp_name'],
                $dirService->addEndSlash($imagePath->getValue()) . ($train->getId() ?? 0),
            );
        }

        $modelManager->saveWithoutChildren($train);

        return $this->returnSuccess($train);
    }

    /**
     * @throws SaveError
     * @throws ViolationException
     * @throws JsonException
     * @throws RecordException
     * @throws ReflectionException
     * @throws ModelDeleteError
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

    /**
     * @throws FileNotFound
     * @throws ImageCreateError
     * @throws LoadError
     */
    #[CheckPermission([Permission::READ])]
    public function getImage(
        DirService $dirService,
        ManipulateService $manipulateService,
        #[GetModel]
        Train $train,
        #[GetSetting('imagePath', 'tc')]
        Setting $imagePath,
        ?int $width = null,
        ?int $height = null,
    ): ImageResponse {
        return new ImageResponse(
            $manipulateService,
            $dirService->addEndSlash($imagePath->getValue()) . ($train->getId() ?? 0),
            $train->getName(),
            $width,
            $height,
        );
    }
}
