<?php
namespace Catalizr\Lib;

use Catalizr\Pagination;

/**
 * Description of Api
 *
 * @author codati
 */
class Api extends Object
{
   /**
    * @param string $prefixTag
    * @param string $classEntity
    * @param string $id id of catalizr
    * @return \Catalizr\Lib\Entity
    * @throws \Catalizr\Lib\HttpException
    */
    protected function getById($prefixTag, $classEntity, $id)
    {
        $object = $this->api->helperRequest->executeReq($prefixTag.'_get',null, [$id]);

        return new $classEntity($object);
    }

    /**
    * @param string|int|double $iid external iid
    * @return \Catalizr\Lib\Entity
    * @throws \Catalizr\Lib\HttpException
    */
    protected function getByExternalId($iid)
    {
        return $this->getById($this->getIdByExternalIid($iid));
    }

    /**
     * @param string $prefixTag
     * @param string|int|double $iid external iid
     * @return string
     * @throws \Catalizr\Lib\HttpException
     */
    protected function getIdByExternalIid($prefixTag, $iid)
    {
        return $this->api->helperRequest->executeReq($prefixTag.'_getiid',null, [(string)$iid])->id;
    }

    /**
     * @param string $prefixTag
     * @param Entity $entity
     * @return Object
     * @throws \Catalizr\Lib\HttpException
     */
    protected function create($prefixTag, Entity &$entity)
    {
        if (isset($entity->iid)) {
            $entity->iid = (string) $entity->iid;
        }
        $object = $this->api->helperRequest->executeReq($prefixTag.'_post', $entity);

        if (isset($object->iid)) {
            $entity->iid = $object->iid;
        }
        $entity->id = $object->id;

        return $object;
    }

    /**
     * @param string $prefixTag
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    protected function getAll($prefixTag, Pagination $pagination = null)
    {
        return $this->api->helperRequest->executeReq($prefixTag.'_getAll', null, null, (array) $pagination);
    }

    /**
     * @param string $prefixTag
     * @param string $id
     * @param Pagination|null $pagination
     * @return array
     * @throws \Catalizr\Lib\HttpException
     */
    protected function getAllById($prefixTag, $id, Pagination $pagination = null)
    {
        return $this->api->helperRequest->executeReq($prefixTag.'_getAll', null, [$id], (array) $pagination);
    }

    /**
     * @param string $prefixTag
     * @param string $id
     * @param \Catalizr\Entity\Documents $document
     * @throws \Catalizr\Lib\HttpException
     */
     protected function createDocumentById($prefixTag, $id, \Catalizr\Entity\Documents &$document)
     {
        if (!is_readable($document->path_to_file) || !is_file($document->path_to_file )) {
            throw new \Exception('document file not exists');
        }

        if (filesize($document->path_to_file) < 2000000) {
            $objectToSend = $document->jsonSerialize();
            $objectToSend['base64'] = base64_encode(file_get_contents($document->path_to_file));
            $object = $this->api->helperRequest->executeReq($prefixTag.'_postDocuments', $objectToSend,[$id]);
        } else {
            $object = $this->api->helperRequest->executeReq($prefixTag.'_postDocuments', $document,[$id]);
            $this->api->helperRequest->executeUpload($document->path_to_file, $object->url,$document->type_mime);
        }

        $document->id = $object->id;
    }

    /**
     * @param string $prefixTag
     * @param Entity $entity
     * @return Entity
     * @throws \Catalizr\Lib\HttpException
     */
    public function update($prefixTag, Entity $entity)
    {
        $safeClonedEntity = clone $entity;
        $notAllowedProperties = Entity::$notAllowedProperties;
        $entityClass = get_class($entity);
        if (isset($entityClass::$notAllowedProperties)) {
            $notAllowedProperties = array_merge($notAllowedProperties, $entityClass::$notAllowedProperties);
        }
        foreach ($notAllowedProperties as $prop) {
            unset($safeClonedEntity->$prop);
        }

        $this->api->helperRequest->executeReq($prefixTag . '_put', $safeClonedEntity, [$entity->id]);

        return self::getById($prefixTag, $entityClass, $entity->id);
    }
}
