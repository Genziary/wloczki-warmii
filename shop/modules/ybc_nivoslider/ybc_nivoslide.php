<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

if (!defined('_PS_VERSION_'))
	exit;
 

class YBCNIVOSLIDE extends ObjectModel
{
	public $title;
	public $description;
	public $url;
	public $legend;
    public $legend2;
	public $image;
	public $active;
	public $position;
	public $id_shop;
    public $caption_top;
    public $caption_left;
    public $caption_right;
    public $caption_width;
    public $caption_position;
    public $caption_animate;
    public $caption_text_direction;
    public $slide_effect;
    public $button_type;
    public $button_text;
    public $color1;
    public $color2;
    public $color3;
    public $color4;
    public $color5;
    public $color6;
    public $color7;
    public $color8;
    public $color9;
    public $color10;
    public $opacity;
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'ybcnivoslider_slides',
		'primary' => 'id_homeslider_slides',
		'multilang' => true,
		'fields' => array(
			'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'position' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'slide_effect' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 50),
            'caption_top' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'button_type' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'caption_left' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'caption_right' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'caption_width' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 50),
            'caption_position' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 50),
            'caption_animate' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 50),
            'caption_text_direction' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 50),
            'color1' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color2' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color3' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color4' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color5' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color6' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color7' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color8' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color9' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'color10' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
            'opacity' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 50),
			// Lang fields
			'description' =>	array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 4000),
			'title' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255),
			'legend' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255),
            'legend2' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255),            
			'url' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'required' => false, 'size' => 255),
			'image' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'button_text' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 300),
		)
	);

	public	function __construct($id_slide = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_slide, $id_lang, $id_shop);
        $languages = Language::getLanguages(false);
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        foreach($languages as $lang)
        {
            foreach(self::$definition['fields'] as $field => $params)
            {   
                $temp = $this->$field; 
                if( $field == 'image' ){
                    if(isset($params['lang']) && $params['lang'] && ( !isset($temp[$lang['id_lang']]) || ( isset($temp[$lang['id_lang']]) && !$temp[$lang['id_lang']]  )) ){
                        $temp[$lang['id_lang']] = $temp && $temp[$id_lang_default] ? $temp[$id_lang_default] : '';
                    }
                }else{
                    if(isset($params['lang']) && $params['lang'] && !isset($temp[$lang['id_lang']])){                      
                        $temp[$lang['id_lang']] = '';                        
                    }
                }
                $this->$field = $temp;
            }
        }
	}

	public function add($autodate = true, $null_values = false)
	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'ybcnivoslider` (`id_shop`, `id_homeslider_slides`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);
		return $res;
	}

	public function delete()
	{
		$res = true;

		$images = $this->image;
		foreach ($images as $image)
		{
			if (preg_match('/sample/', $image) === 0)
				if ($image && file_exists(dirname(__FILE__).'/images/'.$image))
					$res &= @unlink(dirname(__FILE__).'/images/'.$image);
		}

		$res &= $this->reOrderPositions();

		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'ybcnivoslider`
			WHERE `id_homeslider_slides` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}

	public function reOrderPositions()
	{
		$id_slide = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(hss.`position`) as position
			FROM `'._DB_PREFIX_.'ybcnivoslider_slides` hss, `'._DB_PREFIX_.'ybcnivoslider` hs
			WHERE hss.`id_homeslider_slides` = hs.`id_homeslider_slides` AND hs.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_slide)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hss.`position` as position, hss.`id_homeslider_slides` as id_slide
			FROM `'._DB_PREFIX_.'ybcnivoslider_slides` hss
			LEFT JOIN `'._DB_PREFIX_.'ybcnivoslider` hs ON (hss.`id_homeslider_slides` = hs.`id_homeslider_slides`)
			WHERE hs.`id_shop` = '.(int)$id_shop.' AND hss.`position` > '.(int)$this->position
		);

		foreach ($rows as $row)
		{
			$current_slide = new YBCNIVOSLIDE($row['id_slide']);
			--$current_slide->position;
			$current_slide->update();
			unset($current_slide);
		}

		return true;
	}

	public function getAssociatedIdShop()
	{
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_shop`
			FROM `'._DB_PREFIX_.'ybcnivoslider` hs
			WHERE hs.`id_homeslider_slides` = '.(int)$this->id
		);

		return (int)$result[0]['id_shop'];
	}

}
