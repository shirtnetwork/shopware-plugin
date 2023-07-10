<?php declare(strict_types=1);

namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork;

use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\File\MediaFile;
use Shopware\Core\Content\Media\File\FileNameProvider;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Content\Media\File\FileFetcher;
use Shopware\Core\Content\Media\MediaService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;


class MediaSyncer
{

    protected $fileFetcher;
    protected $mediaService;
    protected $apiClient;
    protected $mediaRepository;
    protected $productMediaRepository;
    protected $mediaFolderRepository;
    protected $fileSaver;
    protected $fileNameProvider;

    public function __construct(
        ApiClient $apiClient,
        MediaService $mediaService,
        FileFetcher $fileFetcher,
        FileSaver $fileSaver,
        FileNameProvider $fileNameProvider,
        EntityRepository $mediaRepository,
        EntityRepository $mediaFolderRepository
    )
    {
        $this->apiClient = $apiClient;
        $this->mediaService = $mediaService;
        $this->fileFetcher = $fileFetcher;
        $this->mediaRepository = $mediaRepository;
        $this->mediaFolderRepository = $mediaFolderRepository;
        $this->fileSaver = $fileSaver;
        $this->fileNameProvider = $fileNameProvider;
    }

    public function getMediaFiles(string $salesChannelId, Context $context, $pictures, $type='variants'){
        $medias = [];
        $position = 0;
        foreach($pictures as $picture){
            $media = $this->getMediaFile($salesChannelId, $context, $picture, $type, $position);
            if ($media){
                $medias[] = $media;
                $position++;
            }

        }
        return $medias;
    }

    public function getMediaFile(string $salesChannelId, Context $context, $picture, $type='variants', $position = 0) {
        $url = $this->apiClient->getAssetUrl($salesChannelId, $type, $picture);
        $id = md5('SNW_' . $url, false);

        //$medias = $this->mediaRepository->search((new Criteria())->addFilter(new EqualsFilter('fileName', $id)),Context::createDefaultContext());
        $medias = $this->mediaRepository->search(new Criteria([$id]), $context);

        if ($medias->count()){
            return ['id' => Uuid::randomHex(), 'mediaId' => $medias->first()->getId(), 'position' => $position];
        }else{

            // get fileinfos
            $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
            $fileName = basename($url, '.'.$fileExtension);
            try{
                $mediaFile = $this->fetchFileFromURL($url, $fileExtension);
            }catch(\Exception $ex){
                return false;
            }

            $name = $this->fileNameProvider->provide($fileName, $fileExtension, $id, $context);

            $mediaId = $this->saveFile(
                $mediaFile,
                $name,
                $context,
                'product',
                $id
            );

            return ['id' => Uuid::randomHex(), 'mediaId' => $mediaId, 'position' => $position];
        }
    }

    public function saveFile(
        MediaFile $mediaFile,
        string $filename,
        Context $context,
        ?string $folder = null,
        ?string $mediaId = null
    ): string {

        $mediaId = $this->createMediaInFolder($folder, $context, $mediaId);

        $this->fileSaver->persistFileToMedia($mediaFile, $filename, $mediaId, $context);


        return $mediaId;
    }

    public function createMediaInFolder(string $folder, Context $context, string $id): string
    {
        $this->mediaRepository->upsert(
            [
                [
                    'id' => $id,
                    'private' => false,
                    'mediaFolderId' => $this->getMediaDefaultFolderId($folder, $context),
                ],
            ],
            $context
        );

        return $id;
    }

    private function getMediaDefaultFolderId(string $folder, Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('media_folder.defaultFolder.entity', $folder));
        $criteria->addAssociation('defaultFolder');
        $criteria->setLimit(1);
        $defaultFolder = $this->mediaFolderRepository->search($criteria, $context);
        $defaultFolderId = null;
        if ($defaultFolder->count() === 1) {
            $defaultFolderId = $defaultFolder->first()->getId();
        }

        return $defaultFolderId;
    }

    private function fetchFileFromURL(string $url, string $extension): MediaFile
    {
        $request = new Request();
        $request->query->set('url', $url);
        $request->query->set('extension', $extension);
        $request->request->set('url', $url);
        $request->request->set('extension', $extension);
        $request->headers->set('content-type', 'application/json');

        return $this->mediaService->fetchFile($request);
    }


}
