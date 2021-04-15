<?php


namespace App\Helpers;


use App\Serializer\JsonSerializer;

class ObjectMapper {

  const DATA_FORMAT = 'json';

  public static function map($object, $toClass) {
    if ($object instanceof \stdClass) {
      $object = json_decode(json_encode($object), true);
    }

    $serializer = JsonSerializer::getInstance();

    $serializedEntity = $serializer->serialize($object, self::DATA_FORMAT);

    return $serializer->deserialize($serializedEntity, $toClass, self::DATA_FORMAT);
  }
}
