<?php
declare(strict_types=1);

namespace tests\Services;

use App\Core\Exceptions\ServiceException;
use App\Services\TagService;
use tests\TestCase;
use Throwable;

class TagServiceTests extends TestCase
{

    /**
     * @return TagService
     * @throws ServiceException
     */
    protected function getTagService(): TagService
    {
        try {
            return $this->getAppInstance()->getContainer()->get(TagService::class);
        } catch (Throwable $e) {
            throw new ServiceException();
        }
    }

    /**
     * @throws ServiceException
     */
    public function testLogin()
    {
        $entityList = $this->getTagService()->findAll();
        $this->assertNotNull($entityList);

        $entity = $this->getTagService()->findById(1);
        $this->assertNotNull($entity);
    }

}
