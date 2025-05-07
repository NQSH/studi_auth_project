<?php

use MongoDB\BSON\ObjectId;;

class Article
{
    private static function getCollection()
    {
        return Database::getMongoDBCollection('articles');
    }

    public static function all($page = 1)
    {
        return self::getCollection()
            ->find([], ['sort' => ['created_at' => -1], 'skip' => ($page - 1) * 10, 'limit' => 10])
            ->toArray();
    }

    public static function allByAuthor($authorId)
    {
        return self::getCollection()->find(['author_id' => $authorId], ['sort' => ['created_at' => -1]])->toArray();
    }

    public static function find($id)
    {
        return self::getCollection()->findOne(['_id' => new ObjectId($id)]);
    }

    public static function create($data)
    {
        return self::getCollection()->insertOne($data);
    }

    public static function update($id, $data)
    {
        return self::getCollection()->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => $data]
        );
    }

    public static function delete($id)
    {
        return self::getCollection()->deleteOne(['_id' => new ObjectId($id)]);
    }

    public static function count()
    {
        return self::getCollection()->countDocuments();
    }

    public static function deleteByAuthor($authorId)
    {
        return self::getCollection()->deleteMany(['author_id' => $authorId]);
    }
}
