<?php
namespace app\modules\menu\models;

use Yii;
use app\behaviors\CacheFlush;

class Item extends \app\components\BaseCategoryModel
{
		const STATUS_OFF = 0;
    const STATUS_ON = 1;
		
    public static function tableName()
    {
        return 'menu_item';
    }
		
		public function rules()
    {
        return [
            [['title', 'url'], 'required', 'message'=>Yii::t('app', 'Заповніть, будь ласка, поле "{attribute}"')],
            [['title', 'url'], 'trim'],
            [['title', 'url'], 'string', 'max' => 128, 'message'=>Yii::t('app', 'Кількість символів не повинна перевищувати 128')],
						['parent_id', 'default', 'value' => 0],
            [['status', 'pos'], 'safe'],
						[['title', 'url', 'status', 'pos'], 'safe', 'on'=>'search']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Им\'я'),
						'url' => Yii::t('app', 'URL'),
        ];
    }
		
		public function behaviors()
    {
        $parentsBehaviors = parent::behaviors();
				$behaviors = [
            'cacheflush1' => [
                'class' => CacheFlush::className(),
                'key' => [static::tableName().'_menu']
            ],
        ];
				return array_merge($parentsBehaviors, $behaviors);
    }
		
		public static function menuList()
    {
			$cache = Yii::$app->cache;
      $key = static::tableName().'_menu';
			$menu = $cache->get($key);
			if(!$menu){
				$menu = static::generateMenuList();
        $cache->set($key, $menu, 3600);
       }
			(new self)->_setActiveItem($menu, Yii::$app->request->url);
      return $menu;
    }
		
		public static function generateMenuList()
    {
			$data = self::find()->with('children')
														->where(['parent_id'=>0, 'status'=>self::STATUS_ON])
														->sortPos()
														->all();
			if($data)
				$data =  (new self)->_createList($data);
			return $data;
    }
		
		private function _createList($data, &$list=[])
		{
				foreach($data as $i=>$item) {
					$children = $item->getChildren()->sortPos()->all();
					if($children) {
						$list[$i] = [
								'items' => [],
								'options' => ['class'=>'dropdown'],
								'submenuTemplate' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
																			aria-expanded="false">' . $item->title .
																			'<span class="caret"></span></a>
																			<ul class="dropdown-menu" role="menu">{items}</ul>',
						];
					}
					else {
						$list[$i] = ['label'=>$item->title, 'url'=>$item->url];
						if($i<count($data)-1)
							$list[$i]['template'] = '<a href="{url}">{label}</a><span></span>';
					}
					if(isset($list[$i]['items'])) {
						$this->_createList($children, $list[$i]['items']);
					}
				}
				return $list;
		}
		private function _setActiveItem(&$items, $url)
		{
				foreach($items as &$item) {
					if(isset($item['items'])) {
						$this->_setActiveItem($item['items'], $url);
						break;
					}
					elseif(($item['url']==$url && $item['url']=='/') || strpos($url, $item['url']) !== false && $item['url']!='/') {
						$item['active'] = true;
						break;
					}
				}
		}
}