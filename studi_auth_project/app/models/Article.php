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
        $articles = self::getCollection()
            ->find([], ['sort' => ['created_at' => -1], 'skip' => ($page - 1) * 10, 'limit' => 10])
            ->toArray();

        foreach ($articles as $article) {
            $article['author'] = User::findById($article['author_id'])->username;
        }

        return $articles;
    }

    public static function allByAuthor($authorId)
    {
        return self::getCollection()->find(['author_id' => $authorId], ['sort' => ['created_at' => -1]])->toArray();
    }

    public static function find($id)
    {
        $article = self::getCollection()->findOne(['_id' => new ObjectId($id)]);
        $article['author'] = User::findById($article['author_id'])->username;
        return $article;
    }

    public static function create(string $authorId, string $content)
    {
        if (empty($content)) {
            throw new Exception("Le contenu de l'article ne peut pas être vide.");
        }

        if (strlen($content) > 5000) {
            throw new Exception("Le contenu de l'article ne peut pas dépasser 5000 caractères.");
        }

        if (!User::exists($authorId)) {
            throw new Exception("L'auteur de l'article n'existe pas.");
        }

        $data = [
            'author_id' => $authorId,
            'content' => cleanInput($content),
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ];

        return self::getCollection()->insertOne($data);
    }

    public static function update($id, $data)
    {
        if (empty($data['content'])) {
            throw new Exception("Le contenu de l'article ne peut pas être vide.");
        }
        if (strlen($data['content']) > 5000) {
            throw new Exception("Le contenu de l'article ne peut pas dépasser 5000 caractères.");
        }

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
