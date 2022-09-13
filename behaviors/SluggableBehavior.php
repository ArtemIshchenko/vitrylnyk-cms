<?php
namespace app\behaviors;

use Yii;
use app\helpers\Inflector;
use yii\validators\UniqueValidator;

/**
 * Status behavior. Adds statuses to models
 * @package yii\easyii\behaviors
 */
class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
	public function init() {
		$this->immutable = true;
		parent::init();
	}
   protected function getValue($event)
    {
        $isNewSlug = true;

        if ($this->attribute !== null) {
            $attributes = (array) $this->attribute;
            /* @var $owner BaseActiveRecord */
            $owner = $this->owner;
            if (!empty($owner->{$this->slugAttribute})) {
                $isNewSlug = false;
                if (!$this->immutable) {
                    foreach ($attributes as $attribute) {
                        if ($owner->isAttributeChanged($attribute)) {
                            $isNewSlug = true;
                            break;
                        }
                    }
                }
            }

            if ($isNewSlug) {
                $slugParts = [];
                foreach ($attributes as $attribute) {
                    $slugParts[] = $owner->{$attribute};
                }
                $slug = Inflector::slug(implode('-', $slugParts));
            } else {
                $slug = $owner->{$this->slugAttribute};
            }
        } else {
            $slug = parent::getValue($event);
        }

        if ($this->ensureUnique && $isNewSlug) {
            $baseSlug = $slug;
            $iteration = 0;
            while (!$this->validateSlug($slug)) {
                $iteration++;
                $slug = $this->generateUniqueSlug($baseSlug, $iteration);
            }
        }
        return $slug;
    }
		    /**
     * Checks if given slug value is unique.
     * @param string $slug slug value
     * @return boolean whether slug is unique.
     */
    private function validateSlug($slug)
    {
        /* @var $validator UniqueValidator */
        /* @var $model BaseActiveRecord */
        $validator = Yii::createObject(array_merge(
            [
                'class' => UniqueValidator::className()
            ],
            $this->uniqueValidator
        ));

        $model = clone $this->owner;
        $model->clearErrors();
        $model->{$this->slugAttribute} = $slug;

        $validator->validateAttribute($model, $this->slugAttribute);
        return !$model->hasErrors();
    }

    /**
     * Generates slug using configured callback or increment of iteration.
     * @param string $baseSlug base slug value
     * @param integer $iteration iteration number
     * @return string new slug value
     * @throws \yii\base\InvalidConfigException
     */
    private function generateUniqueSlug($baseSlug, $iteration)
    {
        if (is_callable($this->uniqueSlugGenerator)) {
            return call_user_func($this->uniqueSlugGenerator, $baseSlug, $iteration, $this->owner);
        } else {
            return $baseSlug . '-' . ($iteration + 1);
        }
    }
}