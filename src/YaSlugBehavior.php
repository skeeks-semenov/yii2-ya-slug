<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 04.11.2017
 */
namespace skeeks\yii2\yaslug;
use Cocur\Slugify\RuleProvider\RuleProviderInterface;
use Cocur\Slugify\Slugify;

use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\base\Event;

/**
 * Class SlugBehavior
 * @package skeeks\yii2\slug
 */
class YaSlugBehavior extends AttributeBehavior
{
    /**
     * The attribute to be generated
     * @var string
     */
    public $slugAttribute  = '';

    /**
     * The attribute from which will be generated
     * @var string
     */
    public $attribute      = '';

    /**
     * Slug attribute must be unique
     * @var bool
     */
    public $ensureUnique   = true;

    /**
     * Maximum length of attribute slug
     * @var int
     */
    public $maxLength      = 64;

    /**
     * Min length of attribute slug
     * @var int
     */
    public $minLength      = 3;

    /**
     * @var
     */
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->slugAttribute || !$this->attribute) {
            throw new InvalidConfigException('Incorrectly configured behavior.');
        }

        if (empty($this->attributes))
        {
            $this->attributes =
            [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->slugAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->slugAttribute],
            ];
        }
    }

    /**
     * @param Event $event
     * @return mixed|string
     */
    public function getValue($event)
    {
        if (!$this->value)
        {
            if ($this->owner->{$this->slugAttribute})
            {
                $slug = YaSlugHelper::slugify($this->owner->{$this->slugAttribute});
            } else
            {
                $slug = YaSlugHelper::slugify($this->owner->{$this->attribute});
            }

            if (strlen($slug) < $this->minLength) {
                $slug = $slug . "-" . md5(microtime());
            }

            if (strlen($slug) > $this->maxLength) {
                $slug = substr($slug, 0, $this->maxLength);
            }

            if ($this->ensureUnique)
            {
                if (!$this->owner->isNewRecord)
                {
                    if ($founded = $this->owner->find()->where([
                        $this->slugAttribute => $slug
                    ])->andWhere(["!=", "id", $this->owner->id])->one())
                    {
                        if ($last = $this->owner->find()->orderBy('id DESC')->limit(1)->one())
                        {
                            $slug = $slug . '-' . substr(md5(microtime()), 0, 5);
                            return YaSlugHelper::slugify($slug);
                        }
                    }
                } else
                {
                    if ($founded = $this->owner->find()->where([
                        $this->slugAttribute => $slug
                    ])->one())
                    {
                        if ($last = $this->owner->find()->orderBy('id DESC')->limit(1)->one())
                        {
                            $slug = $slug . '-' . substr(md5(microtime()), 0, 5);
                            return YaSlugHelper::slugify($slug);
                        }
                    }
                }
            }

            return $slug;
        } else
        {
            return call_user_func($this->value, $event);
        }
    }
}
