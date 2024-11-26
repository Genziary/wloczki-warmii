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

include_once(_PS_MODULE_DIR_.'ybc_nivoslider/ybc_nivoslide.php');

class Ybc_nivoslider extends Module
{
    public $is17;
    public $is16;
    public $fields_form;

	private $_html = '';
	private $default_width = '100%';
    private $default_height = '100%';
    private $default_frame_width = '100%';
    private $default_caption_speed = '200';
	private $default_speed = 500;
	private $default_pause = 5000;
	private $default_loop = 0;
    private $default_start_slide = 1;
    private $default_pause_on_hover = 1;
    private $default_show_control = 1;
    private $default_show_prev_next = 1;
    private $default_color = '#E94C6F';
    private $default_hide_caption = 0;
    //Caption options
    private $default_caption_width = '35%';
    private $default_caption_position = 'left';
    private $default_caption_animate = 'random';
    private $default_caption_left = '8%';
    private $default_caption_right = '8%';
    private $default_caption_top = '8%';
    private $default_slide_effect = 'random';
    private $default_caption_text_direction = 'left';
    private $default_button_type = 0;
    private $default_color1 = '#333333';
    private $default_color2 = '#E94C6F';
    private $default_color3 = '#E94C6F';
    private $default_color4 = '#333333';
    private $default_color5 = '#ffffff';
    private $default_color6 = '#ffffff';
    private $default_color7 = '#ffffff';
    private $default_color8 = '#ffffff';
    private $default_color9 = '#ffffff';
    private $default_color10 = '#ff1142';
    private $default_opacity = '0.7';
    protected $imgDir;
    protected $imgPath;
    public $refs;
	public function __construct()
	{
		$this->name = 'ybc_nivoslider';
		$this->tab = 'front_office_features';
		$this->version = '1.0.9';
		$this->author = 'PrestaHero';
		$this->need_instance = 0;
		$this->module_key = Tools::encrypt($this->name);
		$this->bootstrap = true;
        $this->imgDir = _PS_IMG_DIR_.$this->name.'/';
        $this->imgPath = _PS_IMG_.$this->name.'/';

		parent::__construct();

        $this->is17 = version_compare(_PS_VERSION_, '1.7.0', '>=');
        $this->is16 = version_compare(_PS_VERSION_, '1.6.0', '>=');
		$this->displayName = $this->l('Pretty Nivo slider');
		$this->description = $this->l('Your home Nivo slider with nice captions');
$this->refs = 'https://prestahero.com/';
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);    
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
		if (parent::install() &&
			$this->registerHook('displayHeader') &&
			$this->registerHook('displayTopColumn') &&
			$this->registerHook('displayHome') &&
            $this->registerHook('displayBackOfficeHeader') && 
			$this->registerHook('actionShopDataDuplication')
		)
		{		
            $this->createImgDir();
			/* Sets up Global configuration */
			$res = Configuration::updateValue('YBCNIVO_WIDTH', $this->default_width);
            $res &= Configuration::updateValue('YBCNIVO_HEIGHT', $this->default_height);
			$res &= Configuration::updateValue('YBCNIVO_SPEED', $this->default_speed);
			$res &= Configuration::updateValue('YBCNIVO_PAUSE', $this->default_pause);
			$res &= Configuration::updateValue('YBCNIVO_LOOP', $this->default_loop);
            $res &= Configuration::updateValue('YBCNIVO_START_SLIDE', $this->default_start_slide);            
            $res &= Configuration::updateValue('YBCNIVO_PAUSE_ON_HOVER', $this->default_pause_on_hover);
            $res &= Configuration::updateValue('YBCNIVO_SHOW_CONTROL', $this->default_show_control);
            $res &= Configuration::updateValue('YBCNIVO_SHOW_PREV_NEXT', $this->default_show_prev_next);
            $res &= Configuration::updateValue('YBCNIVO_CAPTION_SPEED', $this->default_caption_speed);
            $res &= Configuration::updateValue('YBCNIVO_COLOR', $this->default_color);
            $res &= Configuration::updateValue('YBCNIVO_HIDE_CAPTION', $this->default_hide_caption);
            $res &= Configuration::updateValue('YBCNIVO_FRAME_WIDTH', $this->default_frame_width);

			/* Creates tables */
			$res &= $this->createTables();

			/* Adds samples */
			if ($res)
				$this->installSamples();

			return (bool)$res;
		}

		return false;
	}

	/**
	 * Adds samples
	 */
	private function installSamples()
	{
	   $this->install_sql_demo();
	}
    
    public function install_sql_demo(){
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; ++$i)
        {
        	if($i == 1)
            {
                $slide = new YBCNIVOSLIDE();
            	$slide->position = $i;
            	$slide->active = 1;
                $slide->slide_effect = $this->default_slide_effect;
                $slide->caption_top = $this->default_caption_top;
                $slide->caption_left = $this->default_caption_left;
                $slide->caption_right = $this->default_caption_right;
                $slide->caption_width = '45%';
                $slide->caption_position = $this->default_caption_position;
                $slide->caption_animate = $this->default_caption_animate;
                $slide->caption_text_direction = $this->default_caption_text_direction;
                $slide->button_type = 1;
                $slide->color1 = '#ff3974';
                $slide->color2 = '#ff65f9';
                $slide->color3 = $this->default_color3;
                $slide->color4 = '#ffffff';
                $slide->color5 = $this->default_color5;
                $slide->color6 = '#009dcc';
                $slide->color7 = '#a1eaff';
                $slide->color8 = '#e6fffc';
                $slide->color9 = $this->default_color9;
                $slide->color10 = $this->default_color10;
                $slide->opacity = $this->default_opacity;
            	foreach ($languages as $language)
            	{
            		$slide->title[$language['id_lang']] = 'Eiusmod tempor incididunt ut magna';
            		$slide->description[$language['id_lang']] = '<'.'p'.'>'.'Lorem ipsum dolor sit amet, consectetur adipiscing elit des do eiusmod tempor incididunt ut labore et dolore magna aliqua'.'<'.'/'.'p'.'>';
            		$slide->legend[$language['id_lang']] = 'Build your online store in one minute';
                    $slide->legend2[$language['id_lang']] = 'Consectetur adipiscing elit des';
                    
                    $slide->button_text[$language['id_lang']] = '';
            		$slide->url[$language['id_lang']] = '';
                    if(@copy(dirname(__FILE__).'/views/img/temp/sample-'.$i.'.jpg',$this->imgDir.'sample-'.$i.'.jpg'))
            		    $slide->image[$language['id_lang']] = 'sample-'.$i.'.jpg';
                    else
                        $slide->image[$language['id_lang']] = '';
            	}
            	$slide->add();
            }
            elseif($i == 2)
            {
                $slide = new YBCNIVOSLIDE();
        		$slide->position = $i;
        		$slide->active = 1;
                $slide->slide_effect = $this->default_slide_effect;
                $slide->caption_top = $this->default_caption_top;
                $slide->caption_left = $this->default_caption_left;
                $slide->caption_right = $this->default_caption_right;
                $slide->caption_width = $this->default_caption_width;
                $slide->caption_position = $this->default_caption_position;
                $slide->caption_animate = $this->default_caption_animate;
                $slide->caption_text_direction = $this->default_caption_text_direction;
                $slide->button_type = $this->default_button_type;
                $slide->color1 = $this->default_color1;
                $slide->color2 = $this->default_color2;
                $slide->color3 = $this->default_color3;
                $slide->color4 = $this->default_color4;
                $slide->color5 = $this->default_color5;
                $slide->color6 = $this->default_color6;
                $slide->color7 = $this->default_color7;
                $slide->color8 = $this->default_color8;
                $slide->color9 = $this->default_color9;
                $slide->color10 = $this->default_color10;
                $slide->opacity = $this->default_opacity;
        		foreach ($languages as $language)
        		{
        			$slide->title[$language['id_lang']] = 'Your best responsive prestashop theme';
        			$slide->description[$language['id_lang']] = '<'.'p'.'>'.'Lorem ipsum dolor sit amet, consectetur adipiscing elit des do eiusmod tempor incididunt ut labore et dolore magna aliqua'.'<'.'/'.'p'.'>';
        			$slide->legend[$language['id_lang']] = 'Build your online store in one minute';
                    $slide->legend2[$language['id_lang']] = 'Consectetur adipiscing elit des';
                    
                    $slide->button_text[$language['id_lang']] = 'Shop now';
        			$slide->url[$language['id_lang']] = 'http://prestashopaddon.com/';
                    if(@copy(dirname(__FILE__).'/views/img/temp/sample-'.$i.'.jpg',$this->imgDir.'sample-'.$i.'.jpg'))
        			    $slide->image[$language['id_lang']] = 'sample-'.$i.'.jpg';
                    else
                        $slide->image[$language['id_lang']] = '';
        		}
        		$slide->add();
            }
            else
            {
                $slide = new YBCNIVOSLIDE();
            	$slide->position = $i;
            	$slide->active = 1;
                $slide->slide_effect = $this->default_slide_effect;
                $slide->caption_top = $this->default_caption_top;
                $slide->caption_left = $this->default_caption_left;
                $slide->caption_right = $this->default_caption_right;
                $slide->caption_width = '40%';
                $slide->caption_position = $this->default_caption_position;
                $slide->caption_animate = $this->default_caption_animate;
                $slide->caption_text_direction = $this->default_caption_text_direction;
                $slide->button_type = 1;
                $slide->color1 = '#5f5400';
                $slide->color2 = '#e94c6f';
                $slide->color3 = $this->default_color3;
                $slide->color4 = '#ffffff';
                $slide->color5 = $this->default_color5;
                $slide->color6 = '#727300';
                $slide->color7 = '#b9f8ff';
                $slide->color8 = '#f7e1ff';
                $slide->color9 = $this->default_color9;
                $slide->color10 = $this->default_color10;
                $slide->opacity = $this->default_opacity;
            	foreach ($languages as $language)
            	{
            		$slide->title[$language['id_lang']] = 'Eiusmod tempor incididunt ut';
            		$slide->description[$language['id_lang']] = '<'.'p'.'>'.'Lorem ipsum dolor sit amet, consectetur adipiscing elit des do eiusmod tempor incididunt ut labore et dolore magna aliqua'.'<'.'/'.'p'.'>';
            		$slide->legend[$language['id_lang']] = 'Build your online store in one minute';
                    $slide->legend2[$language['id_lang']] = 'Consectetur adipiscing elit des';
                    
                    $slide->button_text[$language['id_lang']] = '';
            		$slide->url[$language['id_lang']] = '';
                    if(@copy(dirname(__FILE__).'/views/img/temp/sample-'.$i.'.jpg',$this->imgDir.'sample-'.$i.'.jpg'))
            		    $slide->image[$language['id_lang']] = 'sample-'.$i.'.jpg';
                    else
                        $slide->image[$language['id_lang']] = '';
            	}
            	$slide->add();
            }
            
        }
    }

	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();

			/* Unsets configuration */
			$res &= Configuration::deleteByName('YBCNIVO_WIDTH');
            $res &= Configuration::deleteByName('YBCNIVO_HEIGHT');
			$res &= Configuration::deleteByName('YBCNIVO_SPEED');
			$res &= Configuration::deleteByName('YBCNIVO_PAUSE');
			$res &= Configuration::deleteByName('YBCNIVO_LOOP');            
            $res &= Configuration::deleteByName('YBCNIVO_START_SLIDE');
			$res &= Configuration::deleteByName('YBCNIVO_PAUSE_ON_HOVER');
			$res &= Configuration::deleteByName('YBCNIVO_SHOW_CONTROL');
			$res &= Configuration::deleteByName('YBCNIVO_SHOW_PREV_NEXT');
            $res &= Configuration::deleteByName('YBCNIVO_CAPTION_SPEED');
            $res &= Configuration::deleteByName('YBCNIVO_COLOR');
            $res &= Configuration::deleteByName('YBCNIVO_HIDE_CAPTION');
			$res &= Configuration::deleteByName('YBCNIVO_FRAME_WIDTH');
            $this->cleanImages();
			return (bool)$res;
		}

		return false;
	}
    private function cleanImages()
    {
        $this->deleteDir(_PS_IMG_DIR_.$this->name);
        return true;
    }
	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* Slides */
		$res = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider` (
				`id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_homeslider_slides`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider_slides` (
			  `id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `position` int(10) unsigned NOT NULL DEFAULT \'0\',
			  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              `button_type` VARCHAR(50) NULL DEFAULT \'default\',  
              `slide_effect` VARCHAR(50) NULL DEFAULT NULL,
              `caption_top` VARCHAR(50) NULL DEFAULT NULL,              
              `caption_left` VARCHAR(50) NULL DEFAULT NULL,
              `caption_right` VARCHAR(50) NULL DEFAULT NULL,
              `caption_animate` VARCHAR(50) NULL DEFAULT NULL,
              `caption_position` VARCHAR(50) NULL DEFAULT NULL,
              `caption_text_direction` VARCHAR(50) NULL DEFAULT NULL,
              `caption_width` VARCHAR(50) NULL DEFAULT NULL,
              `color1` varchar(255) NULL,
              `color2` varchar(255) NULL,
              `color3` varchar(255) NULL,  
              `color4` varchar(255) NULL,     
              `color5` varchar(255) NULL,  
              `color6` varchar(255) NULL, 
              `color7` varchar(255) NULL, 
              `color8` varchar(255) NULL, 
              `color9` varchar(255) NULL, 
              `color10` varchar(255) NULL, 
              `opacity` varchar(255) NULL,                 
			  PRIMARY KEY (`id_homeslider_slides`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		/* Slides lang configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ybcnivoslider_slides_lang` (
			  `id_homeslider_slides` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `legend` varchar(255) NOT NULL,
              `legend2` varchar(255) NOT NULL, 
              `button_text` varchar(255) NULL,                                      
			  `url` varchar(255) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_homeslider_slides`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return $res;
	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$dirs = array('slides');
        foreach($dirs as $dir)
        {
            $files = glob(dirname(__FILE__).'/views/img/'.$dir.'/*'); 
            foreach($files as $file){ 
              if(is_file($file))
                @unlink($file); 
            }
        }   

		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'ybcnivoslider`, `'._DB_PREFIX_.'ybcnivoslider_slides`, `'._DB_PREFIX_.'ybcnivoslider_slides_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();
        if (Tools::getValue('action') == 'updateSlidesPosition' && Tools::getValue('slides') )
        {
            $slides = Tools::getValue('slides');
            $res = true;
            foreach ($slides as $position => $id_slide)
            {
                $res &= Db::getInstance()->execute('
                    UPDATE `'._DB_PREFIX_.'ybcnivoslider_slides` SET `position` = '.(int)$position.'
                    WHERE `id_homeslider_slides` = '.(int)$id_slide
                );

            }
            $this->clearCache();
            die(json_encode(array('res'=>$res)));
        }
		/* Validate & process */
		if (Tools::isSubmit('submitSlide') || Tools::isSubmit('delete_id_slide') ||
			Tools::isSubmit('submitSlider') ||
			Tools::isSubmit('changeStatus')
		)
		{
			if ($this->_postValidation())
			{
				$this->_postProcess();
                if(Tools::isSubmit('show_setting'))
				    $this->_html .= $this->renderForm();
                else
				    $this->_html .= $this->renderList();
			}
			else
            {
                if(!Tools::isSubmit('submitSlider'))
                    $this->_html .= $this->renderAddForm();
                else
                {
                    $this->_html .= $this->renderForm();                   
                }                    
            }			

			$this->clearCache();
		}
		elseif (Tools::isSubmit('addSlide') || (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide'))))
		{
			if (Tools::isSubmit('addSlide'))
				$mode = 'add';
			else
				$mode = 'edit';

			if ($mode == 'add')
			{
				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL)
					$this->_html .= $this->renderAddForm();
				else
					$this->_html .= $this->getShopContextError(null, $mode);
			}
			else
			{
				$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
				$associated_shop_id = $slide->getAssociatedIdShop();
				$context_shop_id = (int)Shop::getContextShopID();

				if (Shop::getContext() != Shop::CONTEXT_GROUP && Shop::getContext() != Shop::CONTEXT_ALL && $associated_shop_id == $context_shop_id)
					$this->_html .= $this->renderAddForm();
				else
				{
					$associated_shop = new Shop($associated_shop_id);
					$this->_html .= $this->getShopContextError($associated_shop->name, $mode);
				}

			}
		}
		else // Default viewport
		{
			$this->_html .= $this->getWarningMultishopHtml().$this->getCurrentShopInfoMsg();
            if(Tools::isSubmit('show_setting'))
                $this->_html .= $this->renderForm();
            else
                $this->_html .= $this->renderList();
		}

		return $this->_html.$this->displayIframe();
	}
    
	private function _postValidation()
	{
		$errors = array();

		/* Validation for Slider configuration */
		if (Tools::isSubmit('submitSlider'))
		{

			$startSlide = Tools::getValue('YBCNIVO_START_SLIDE');
			$captionSpeed = Tools::getValue('YBCNIVO_CAPTION_SPEED');
			$speedNb = Tools::getValue('YBCNIVO_SPEED');
			$pauseTime = Tools::getValue('YBCNIVO_PAUSE');
			if(!$startSlide && !Tools::strlen($startSlide)){
                $errors[] = $this->l('Starting slide field is required');
            }
			elseif((int)$startSlide <= 0){
                $errors[] = $this->l('Starting slide field must be an integer and greater than zero');
            }
			if(!$captionSpeed && !Tools::strlen($captionSpeed)){
                $errors[] = $this->l('Caption delay field is required');
            }
			elseif(!Validate::isInt($captionSpeed) || (int)$captionSpeed <= 0){
                $errors[] = $this->l('Caption delay field must be a number and greater than zero');
            }
			if((int)Tools::getValue('YBCNIVO_LOOP')){
                if(!$speedNb && !Tools::strlen($speedNb)){
                    $errors[] = $this->l('Speed field is required');
                }
                elseif(!Validate::isInt($speedNb) || (int)$speedNb <= 0){
                    $errors[] = $this->l('Speed field must be a number and greater than zero');
                }
            }

			if(!$pauseTime && !Tools::strlen($pauseTime)){
                $errors[] = $this->l('Pause field is required');
            }
			elseif(!Validate::isInt($pauseTime) || (int)$pauseTime <= 0){
                $errors[] = $this->l('Pause field must be a number and greater than zero');
            }

            $width = ltrim(Tools::getValue('YBCNIVO_WIDTH'),'0');
            $frameWidth = ltrim(Tools::getValue('YBCNIVO_FRAME_WIDTH'),'0');
            $height = ltrim(Tools::getValue('YBCNIVO_HEIGHT'),'0');
            if(!$width && !Tools::strlen($width)){
                $errors[] = $this->l('Maximum image width is required');
            }
            else if(!preg_match('/^[0-9]+%$/', $width) && !preg_match('/^[0-9]+px$/', $width))
                $errors[] = $this->l('Maximum image width is not in valid format');
            if(!$height && !Tools::strlen($height)){
                $errors[] = $this->l('Maximum image height is required');
            }
            else if(!preg_match('/^[0-9]+%$/', $height) && !preg_match('/^[0-9]+px$/', $height))
                $errors[] = $this->l('Maximum image height is not in valid format');
            if(!$frameWidth && !Tools::strlen($frameWidth)){
                $errors[] = $this->l('Caption frame width is required');
            }
            else if(!preg_match('/^[0-9]+%$/', $frameWidth) && !preg_match('/^[0-9]+px$/', $frameWidth))
                $errors[] = $this->l('Caption frame width is not in valid format');
            if(trim(Tools::getValue('YBCNIVO_COLOR')) == '')
                $errors[] = $this->l('Next/prev button color is required');
            elseif(!Validate::isColor(Tools::getValue('YBCNIVO_COLOR')))
                $errors[] = $this->l('Next/prev button color is not valid');
				
		} /* Validation for status */
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_slide')))
				$errors[] = $this->l('Invalid slide');
		}
		/* Validation for Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_slide')) || (Tools::getValue('active_slide') != 0 && Tools::getValue('active_slide') != 1))
				$errors[] = $this->l('Invalid slide state.');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid slide position.');
			/* If edit : checks id_slide */
			if (Tools::isSubmit('id_slide'))
			{

				if (!Validate::isInt(Tools::getValue('id_slide')) && !$this->slideExists(Tools::getValue('id_slide')))
					$errors[] = $this->l('Invalid slide ID');
			}
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::strlen(Tools::getValue('title_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The title is too long.');
				if (Tools::strlen(Tools::getValue('legend_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The caption 1 is too long.');
                if (Tools::strlen(Tools::getValue('legend2_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The caption 2 is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 255)
					$errors[] = $this->l('The URL is too long.');
				if (Tools::strlen(Tools::getValue('description_'.$language['id_lang'])) > 4000)
					$errors[] = $this->l('The description is too long.');
                 if (Tools::strlen(Tools::getValue('button_text_'.$language['id_lang'])) > 300)
					$errors[] = $this->l('The button text is too long.');
				if (Tools::strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('The URL format is not correct.');
				$fileImage = isset($_FILES['image_'.$language['id_lang']]) ? $_FILES['image_'.$language['id_lang']] : null;
				if($fileImage && isset($fileImage['name']) && $fileImage['name']){
                    $maxFileSize = (float)Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE') * 1048576;
                    $ext = isset($fileImage['type']) && strpos($fileImage['type'], 'image/') !== false ? explode('/', $fileImage['type'])[1] : '';
                    if(!in_array($ext, array('png', 'jpg', 'jpeg', 'gif'))){
                        $errors[] = sprintf($this->l('The image in "%s" is not image format'), $language['iso_code']);
                    }
				    elseif(ImageManager::validateUpload($fileImage, $maxFileSize))
                        $errors[] = sprintf($this->l('Image is too large %s. Maximum allowed: %s'), round((int)$fileImage['size'] / 1048576, 2).'Mb', (float)Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE').'Mb');
                }
				if(isset($fileImage) && isset($fileImage['name']) && $fileImage['name'] && !Validate::isFileName($fileImage['name'])){
                    $errors[] = sprintf($this->l('"%s" Image name is invalid'), $language['iso_code']);
                }
				else if (Tools::getValue('image_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
				if (Tools::getValue('image_old_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_old_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename.');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			
            $caption_width = ltrim(Tools::getValue('caption_width'),'0');
            if(Tools::getValue('caption_top') != '0')
                $caption_top = ltrim(Tools::getValue('caption_top'),'0');
            else
                $caption_top = '0';
            if(Tools::getValue('caption_left') != '0')
                $caption_left = ltrim(Tools::getValue('caption_left'),'0');
            else
                $caption_left = '0';
            if(Tools::getValue('caption_right') != '0')
                $caption_right = ltrim(Tools::getValue('caption_right'),'0');
            else
                $caption_right = '0';           
            
            $caption_position = trim(Tools::getValue('caption_position'));
            $caption_text_direction = trim(Tools::getValue('caption_text_direction'));
            $caption_animate = trim(Tools::getValue('caption_animate'));
            $slide_effect = trim(Tools::getValue('slide_effect'));
            $opacity = (float)Tools::getValue('opacity');
            if($opacity < 0 || $opacity > 1)
                $errors[] = $this->l('Opacity is not valid');
                        
            if(empty($caption_position) || empty($caption_animate) || empty($caption_text_direction) || empty($slide_effect))
            {
               $errors[] = $this->l('Slide effect, caption position, caption text direction and caption animate are required'); 
            }
            
            if(!preg_match('/^[0-9]+%$/', $caption_width) && !preg_match('/^[0-9]+px$/', $caption_width))
                $errors[] = $this->l('Caption width is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_top) && !preg_match('/^[0-9]+px$/', $caption_top) && $caption_top!='0')
                $errors[] = $this->l('Caption top is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_left) && !preg_match('/^[0-9]+px$/', $caption_left) && $caption_left!='0')
                $errors[] = $this->l('Caption left is not in valid format');
            if(!preg_match('/^[0-9]+%$/', $caption_right) && !preg_match('/^[0-9]+px$/', $caption_right) && $caption_right!='0')
                $errors[] = $this->l('Caption right is not in valid format');
            
            if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('The image is not set.');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('The image is not set.');
            for($i = 1; $i <= 10; $i++)
            {
                if(!Validate::isColor(Tools::getValue('color'.$i)))
                {
                    $errors[] = $this->l('Please check your color codes again. Some of theme are not valid');
                    break;
                }
            }
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_slide') && (!Validate::isInt(Tools::getValue('delete_id_slide')) || !$this->slideExists((int)Tools::getValue('delete_id_slide'))))
			$errors[] = $this->l('Invalid slide ID');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));

			return false;
		}

		/* Returns if validation is ok */

		return true;
	}

	private function _postProcess()
	{
		$errors = array();

		/* Processes Slider */
		if (Tools::isSubmit('submitSlider'))
		{
			$res = Configuration::updateValue('YBCNIVO_WIDTH', (string)Tools::getValue('YBCNIVO_WIDTH'));
            $res &= Configuration::updateValue('YBCNIVO_HEIGHT', (string)Tools::getValue('YBCNIVO_HEIGHT'));
			$res &= Configuration::updateValue('YBCNIVO_SPEED', (int)Tools::getValue('YBCNIVO_SPEED'));
			$res &= Configuration::updateValue('YBCNIVO_PAUSE', (int)Tools::getValue('YBCNIVO_PAUSE'));
			$res &= Configuration::updateValue('YBCNIVO_LOOP', (int)Tools::getValue('YBCNIVO_LOOP'));
            
            $res &= Configuration::updateValue('YBCNIVO_START_SLIDE', (int)Tools::getValue('YBCNIVO_START_SLIDE'));
			$res &= Configuration::updateValue('YBCNIVO_PAUSE_ON_HOVER', (int)Tools::getValue('YBCNIVO_PAUSE_ON_HOVER'));
			$res &= Configuration::updateValue('YBCNIVO_SHOW_CONTROL', (int)Tools::getValue('YBCNIVO_SHOW_CONTROL'));
            $res &= Configuration::updateValue('YBCNIVO_SHOW_PREV_NEXT', (int)Tools::getValue('YBCNIVO_SHOW_PREV_NEXT'));
			$res &= Configuration::updateValue('YBCNIVO_CAPTION_SPEED', (int)Tools::getValue('YBCNIVO_CAPTION_SPEED'));
            $res &= Configuration::updateValue('YBCNIVO_COLOR', Tools::getValue('YBCNIVO_COLOR'));
            $res &= Configuration::updateValue('YBCNIVO_HIDE_CAPTION', (int)Tools::getValue('YBCNIVO_HIDE_CAPTION') ? 1 : 0);
            $res &= Configuration::updateValue('YBCNIVO_FRAME_WIDTH', ltrim(Tools::getValue('YBCNIVO_FRAME_WIDTH'),'0'));
			

			$this->clearCache();

			if (!$res)
				$errors[] = $this->displayError($this->l('The configuration could not be updated.'));
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&show_setting=true');
		} /* Process Slide status */
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_slide'))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			if ($slide->active == 0)
				$slide->active = 1;
			else
				$slide->active = 0;
			$res = $slide->update();
			$this->clearCache();
			$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('The configuration could not be updated.')));
		}
		/* Processes Slide */
		elseif (Tools::isSubmit('submitSlide'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_slide'))
			{
				$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
				if (!Validate::isLoadedObject($slide))
				{
					$this->_html .= $this->displayError($this->l('Invalid slide ID'));

					return false;
				}
			}
			else
				$slide = new YBCNIVOSLIDE();
			/* Sets position */
			$slide->position = (int)Tools::getValue('position');
			/* Sets active */
			$slide->active = (int)Tools::getValue('active_slide');
            $slide->button_type = trim(Tools::getValue('button_type', 'default'));
            $slide->caption_top = ltrim(Tools::getValue('caption_top'),'0');
            $slide->caption_left = ltrim(Tools::getValue('caption_left'),'0');
            $slide->caption_right = ltrim(Tools::getValue('caption_right'),'0');
            $slide->caption_width = ltrim(Tools::getValue('caption_width'),'0');
            $slide->caption_position = trim(Tools::getValue('caption_position'));
            $slide->caption_animate = trim(Tools::getValue('caption_animate'));
            $slide->caption_text_direction = trim(Tools::getValue('caption_text_direction'));
            $slide->slide_effect = trim(Tools::getValue('slide_effect'));
            $slide->color1 = trim(Tools::getValue('color1'));
            $slide->color2 = trim(Tools::getValue('color2'));
            $slide->color3 = trim(Tools::getValue('color3'));
            $slide->color4 = trim(Tools::getValue('color4'));
            $slide->color5 = trim(Tools::getValue('color5'));
            $slide->color6 = trim(Tools::getValue('color6'));
            $slide->color7 = trim(Tools::getValue('color7'));
            $slide->color8 = trim(Tools::getValue('color8'));
            $slide->color9 = trim(Tools::getValue('color9'));
            $slide->color10 = trim(Tools::getValue('color10'));
            $slide->opacity = (float)trim(Tools::getValue('opacity'));
			/* Sets each langue fields */
			$languages = Language::getLanguages(false);
            $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
			foreach ($languages as $language)
			{
				$slide->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) ?: trim(Tools::getValue('title_'.$defaultLang));
				$slide->url[$language['id_lang']] = trim(Tools::getValue('url_'.$language['id_lang'])) ?: trim(Tools::getValue('url_'.$defaultLang));
				$slide->legend[$language['id_lang']] = trim(Tools::getValue('legend_'.$language['id_lang'])) ?: trim(Tools::getValue('legend_'.$defaultLang));
                $slide->legend2[$language['id_lang']] = trim(Tools::getValue('legend2_'.$language['id_lang'])) ?: trim(Tools::getValue('legend2_'.$defaultLang));
				$slide->description[$language['id_lang']] = trim(Tools::getValue('description_'.$language['id_lang'])) ?: trim(Tools::getValue('description_'.$defaultLang));
                $slide->button_text[$language['id_lang']] = trim(Tools::getValue('button_text_'.$language['id_lang'])) ?: trim(Tools::getValue('button_text_'.$defaultLang));
                /* Uploads image and sets slide */
				$type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
				if (isset($_FILES['image_'.$language['id_lang']]) &&
					isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					($imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name'])) &&
					!empty($imagesize) &&
					in_array(
						Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array(
							'jpg',
							'gif',
							'jpeg',
							'png'
						)
					) &&
					in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
				)
				{
					$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
					$salt = sha1(microtime());
					$imgName = $salt.'.'.pathinfo($_FILES['image_'.$language['id_lang']]['name'], PATHINFO_EXTENSION);
					if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']]))
						$errors[] = $error;
					elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name))
						return false;
					elseif (!ImageManager::resize($temp_name, $this->imgDir. $imgName, null, null, $type))
						$errors[] = $this->l('An error occurred during the image upload process.');
					@unlink($temp_name);
					if($slide->image[$language['id_lang']]){
                        $deleteOldImage = true;
					    foreach ($languages as $lang){
					        if($lang['id_lang'] == $language['id_lang']){
					            continue;
                            }
					        if($slide->image[$lang['id_lang']] && $slide->image[$lang['id_lang']] == $slide->image[$language['id_lang']]){
					            $deleteOldImage = false;
					            break;
                            }
                        }
					    if($deleteOldImage){
                            if(@file_exists(dirname(__FILE__).'/views/img/slides/'.$slide->image[$language['id_lang']])){
                                @unlink(dirname(__FILE__).'/views/img/slides/'.$slide->image[$language['id_lang']]);
                            }
                            if(@file_exists($this->imgDir.$slide->image[$language['id_lang']])){
                                @unlink($this->imgDir.$slide->image[$language['id_lang']]);
                            }
                        }
                    }
					$slide->image[$language['id_lang']] = $imgName;
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$slide->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
				if(!$slide->image[$language['id_lang']]){
                    $slide->image[$language['id_lang']] = $slide->image[$defaultLang];
                }
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_slide'))
				{
					if (!$slide->add())
						$errors[] = $this->displayError($this->l('The slide could not be added.'));
				}
				/* Update */
				elseif (!$slide->update())
					$errors[] = $this->displayError($this->l('The slide could not be updated.'));
				$this->clearCache();
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_slide'))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('delete_id_slide'));
			$languages = Language::getLanguages(false);
			foreach ($languages as $lang){
			    if(isset($slide->image[$lang['id_lang']]) && $slide->image[$lang['id_lang']]){
                    if(@file_exists(dirname(__FILE__).'/views/img/slides/'.$slide->image[$lang['id_lang']])){
                        @unlink(dirname(__FILE__).'/views/img/slides/'.$slide->image[$lang['id_lang']]);
                    }
                    if(@file_exists($this->imgDir.$slide->image[$lang['id_lang']])){
                        @unlink($this->imgDir.$slide->image[$lang['id_lang']]);
                    }
                }
            }
			$res = $slide->delete();
			$this->clearCache();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitSlide') && Tools::getValue('id_slide'))
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_slide='.Tools::getValue('id_slide'));
		elseif (Tools::isSubmit('submitSlide'))
        {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_slide='.Db::getInstance()->Insert_ID());
        }

	}

	private function _prepareHook()
	{
		if (true)
		{
		    $id_lang = $this->context->language->id;
			$slides = $this->getSlides(true, $id_lang);
            if(!$slides)
                $slides = $this->getSlides(true, (int)Configuration::get('PS_LANG_DEFAULT'));
			if (is_array($slides))
				foreach ($slides as &$slide)
				{
					$slide['sizes'] = @getimagesize((dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$slide['image']));
					if (isset($slide['sizes'][3]) && $slide['sizes'][3])
						$slide['size'] = $slide['sizes'][3];
				}

			if (!$slides)
				return false;

            $options = array(
                'max_width' => Configuration::get('YBCNIVO_WIDTH'),
                'max_height' => Configuration::get('YBCNIVO_HEIGHT')
            );
			$this->smarty->assign(
                        array(
                            'homeslider_slides' => $slides,
                            'options' => $options,
                            'ybc_nivo_dir' => $this->_path,
                            'page_name' => Tools::getValue('controller'),
                            'hide_caption' => (int)Configuration::get('YBCNIVO_HIDE_CAPTION') ? true : false));
		}

		return true;
	}

    public function hookDisplayBackOfficeHeader()
    {
        if(Tools::getValue('controller') == 'AdminModules' && Tools::getValue('configure') == $this->name){
            $this->context->controller->addCSS($this->_path . 'views/css/admin.css', 'all');
            $this->smarty->assign(array(
                    'linkAdminJs' => $this->_path.'views/js/admin.js',
                    'module_link' => $this->context->shop->physical_uri.$this->context->shop->virtual_uri,
                    'module_key' => $this->module_key,
                    'module_url' => $this->context->link->getAdminLink('AdminModules').'&configure=ybc_nivoslider',
            ));
        }
        return $this->display(__FILE__, 'admin_head.tpl');

    }

	public function hookdisplayHeader($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;
		$this->context->controller->addCSS($this->_path.'views/css/default.css');
        $this->context->controller->addCSS($this->_path.'views/css/nivo-slider.css');
		$this->context->controller->addJS($this->_path.'views/js/jquery.nivo.slider.js');
        $this->context->controller->addJS($this->_path.'views/js/ybcnivoslider.js');
        if ( $this->is17 ){
            $this->context->controller->addCSS($this->_path.'views/css/font-awesome.css');
        }
        $this->smarty->assign(array('ybcnivo' => $this->getConfigFieldsValues(), 'ybcnivostyle' => $this->renderCss()));
		return $this->display(__FILE__, 'header.tpl');
    }

	public function hookdisplayTop($params)
	{
		return $this->hookdisplayTopColumn($params);
	}

	public function hookdisplayTopColumn($params)
	{
		if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
			return;

		if (!$this->_prepareHook())
			return false;
		return $this->display(__FILE__, 'ybc_nivoslider.tpl', $this->getCacheId('ybc_nivoslider.tpl'));
	}

	public function hookDisplayHome()
	{
	   if($this->is17)
       {
    		if (!$this->_prepareHook())
    			return false;
    		return $this->display(__FILE__, 'ybc_nivoslider.tpl');
       }
	}

	public function clearCache()
	{
		$this->_clearCache('ybc_nivoslider.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
			INSERT IGNORE INTO '._DB_PREFIX_.'ybcnivoslider (id_homeslider_slides, id_shop)
			SELECT id_homeslider_slides, '.(int)$params['new_id_shop'].'
			FROM '._DB_PREFIX_.'ybcnivoslider
			WHERE id_shop = '.(int)$params['old_id_shop']
		);
		$this->clearCache();
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');

        /* Style & js for fieldset 'slides configuration' */
        ob_start();
        $this->context->controller->addJS($this->_path.'views/js/header.js');
        $html = ob_get_contents();
        ob_end_clean();        
		return $html;
	}

	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT MAX(hss.`position`) AS `next_position`
			FROM `'._DB_PREFIX_.'ybcnivoslider_slides` hss, `'._DB_PREFIX_.'ybcnivoslider` hs
			WHERE hss.`id_homeslider_slides` = hs.`id_homeslider_slides` AND hs.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	public function getSlides($active = null, $id_lang = 0)
	{
	    if(!$id_lang)
            $id_lang = (int)$this->context->language->id;
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_homeslider_slides` as id_slide, hssl.`image`, hss.`position`, hss.`color1`,hss.`color2`,hss.`color3`,hss.`color4`,hss.`color5`,hss.`color6`,hss.`color7`,hss.`color8`,hss.`color9`,hss.`color10`,hss.`opacity`, hss.`active`,hss.`button_type`, hssl.`title`,hss.`caption_top`,hss.`caption_left`,hss.`caption_right`,hss.`caption_width`,hss.`caption_position`,hss.`caption_text_direction`,hss.`slide_effect`,hss.`caption_animate`,
			hssl.`url`, hssl.`legend`,hssl.`legend2`, hssl.`description`, hssl.`image`,hssl.`button_text`
			FROM '._DB_PREFIX_.'ybcnivoslider hs
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides hss ON (hs.id_homeslider_slides = hss.id_homeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides_lang hssl ON (hss.id_homeslider_slides = hssl.id_homeslider_slides)
			WHERE id_shop = '.(int)$id_shop.'
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hss.`active` = 1' : ' ').'
			ORDER BY hss.position'
		);
	}

	public function getAllImagesBySlidesId($id_slides, $active = null, $id_shop = null)
	{
		$this->context = Context::getContext();
		$images = array();

		if (!isset($id_shop))
			$id_shop = $this->context->shop->id;

		$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hssl.`image`, hssl.`id_lang`
			FROM '._DB_PREFIX_.'ybcnivoslider hs
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides hss ON (hs.id_homeslider_slides = hss.id_homeslider_slides)
			LEFT JOIN '._DB_PREFIX_.'ybcnivoslider_slides_lang hssl ON (hss.id_homeslider_slides = hssl.id_homeslider_slides)
			WHERE hs.`id_homeslider_slides` = '.(int)$id_slides.' AND hs.`id_shop` = '.(int)$id_shop.
			($active ? ' AND hss.`active` = 1' : ' ')
		);

		foreach ($results as $result)
			$images[$result['id_lang']] = $result['image'];

		return $images;
	}

	public function displayStatus($id_slide, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
		$class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
		$html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.
			'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_slide='.(int)$id_slide.'" title="'.$title.'">'.'<'.'i class="'.$icon.'">'.'<'.'/'.'i'.'> '.$title.'<'.'/'.'a'.'>';

		return $html;
	}

	public function slideExists($id_slide)
	{
		$req = 'SELECT hs.`id_homeslider_slides` as id_slide
				FROM `'._DB_PREFIX_.'ybcnivoslider` hs
				WHERE hs.`id_homeslider_slides` = '.(int)$id_slide;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function renderList()
	{ 
		$slides = $this->getSlides();
		foreach ($slides as $key => $slide)
			$slides[$key]['status'] = $this->displayStatus($slide['id_slide'], $slide['active']);

		$this->context->smarty->assign(
			array(
				'link' => $this->context->link,
				'slides' => $slides,
				'image_baseurl' => $this->imgPath,
			)
		);

		return $this->display(__FILE__, 'list.tpl');
	}

	public function renderAddForm()
	{
	   
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Slide information'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'file_lang',
						'label' => $this->l('Select a file'),
						'name' => 'image',
						'lang' => true,
						'desc' => sprintf($this->l('Accepted format: jpg, png, gif, jpeg. Limit: %s Mb. Recommended size: 1110x427px'), Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
                        'required' => true,
					),
					array(
						'type' => 'text',
						'label' => $this->l('Slide title'),
						'name' => 'title',
						'lang' => true,                        
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Title color'),
						'name' => 'color4',						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Title background'),
						'name' => 'color6',						
                        'desc' => $this->l('Leave blank if you do not want to use background'),
					), 

					array(
						'type' => 'text',
						'label' => $this->l('Caption 1'),
						'name' => 'legend',
						'lang' => true,
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Caption 1 color'),
						'name' => 'color1',						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Caption 1 background'),
						'name' => 'color7',						
                        'desc' => $this->l('Leave blank if you do not want to use background'),
					), 
                    array(
						'type' => 'text',
						'label' => $this->l('Caption 2'),
						'name' => 'legend2',
						'lang' => true,
					), 
                    array(
						'type' => 'color',
						'label' => $this->l('Caption 2 color'),
						'name' => 'color2',						
					),  
                    array(
						'type' => 'color',
						'label' => $this->l('Caption 2 background'),
						'name' => 'color8',						
                        'desc' => $this->l('Leave blank if you do not want to use background'),
					), 
                    array(
						'type' => 'textarea',
						'label' => $this->l('Description'),
						'name' => 'description',
						'autoload_rte' => true,
						'lang' => true,
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Description background'),
						'name' => 'color9',						
                        'desc' => $this->l('Leave blank if you do not want to use background'),
					), 
                    array(
						'type' => 'text',
						'label' => $this->l('Button text'),
						'name' => 'button_text',						
						'lang' => true,
                        'desc' => $this->l('Leave blank if you do not want to use button'),
					),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Target URL'),
                        'name' => 'url',
                        'lang' => true,
                    ),
                    array(
						'type' => 'color',
						'label' => $this->l('Button background color'),
						'name' => 'color3',						
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Button background hover color'),
						'name' => 'color10',						
					), 	
                    array(
						'type' => 'color',
						'label' => $this->l('Button text color'),
						'name' => 'color5',						
					),  	
                    
                    array(
						'type' => 'text',
						'label' => $this->l('Caption top'),
						'name' => 'caption_top',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),
                        'required' => true,                       				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption left'),
						'name' => 'caption_left',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),  
                        'required' => true,                     				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption right'),
						'name' => 'caption_right',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 0, 30px, 10%'),    
                        'required' => true,                   				
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption width'),
						'name' => 'caption_width',
                        'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 300px, 40%'), 
                        'required' => true,                      				
					),
                    array(
						'type' => 'select',
						'label' => $this->l('Caption position'),
						'name' => 'caption_position',
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'left',              
                                    'name' => $this->l('Left') 
                                ),
                                array(
                                    'id_option' => 'center',              
                                    'name' => $this->l('Center') 
                                ),
                                array(
                                    'id_option' => 'right',              
                                    'name' => $this->l('Right') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    array(
						'type' => 'select',
						'label' => $this->l('Caption text direction'),
						'name' => 'caption_text_direction',
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'left',              
                                    'name' => $this->l('Left') 
                                ),
                                array(
                                    'id_option' => 'center',              
                                    'name' => $this->l('Center') 
                                ),
                                array(
                                    'id_option' => 'right',              
                                    'name' => $this->l('Right') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    
                    array(
						'type' => 'text',
						'label' => $this->l('Caption background opacity'),
						'name' => 'opacity',						
                        'desc' => $this->l('From 0 to 1. Eg: 0.5, 1...'),
					), 
                    array(
						'type' => 'select',
						'label' => $this->l('Caption animation effect'),
						'name' => 'caption_animate',
                		'options' => array(
                			'query' => array(                                
                                array(
                                    'id_option' => 'random',              
                                    'name' => $this->l('Random') 
                                ),
                                array(
                                    'id_option' => 'repeat',              
                                    'name' => $this->l('Repeat') 
                                ),
                                array(
                                    'id_option' => 'left',              
                                    'name' => $this->l('Fly left') 
                                ),
                                array(
                                    'id_option' => 'right',              
                                    'name' => $this->l('Fly right') 
                                ),
                                array(
                                    'id_option' => 'left-right',              
                                    'name' => $this->l('Fly left right') 
                                ),
                                array(
                                    'id_option' => 'close',              
                                    'name' => $this->l('Close') 
                                ),
                                array(
                                    'id_option' => 'fade',              
                                    'name' => $this->l('Fade') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),   
                    array(
						'type' => 'select',
						'label' => $this->l('Slide transition effect'),
						'name' => 'slide_effect',
                		'options' => array(
                			'query' => array(
                                array(
                                    'id_option' => 'random',              
                                    'name' => $this->l('Random') 
                                ),
                                array(
                                    'id_option' => 'fade',              
                                    'name' => $this->l('Fade') 
                                ),
                                array(
                                    'id_option' => 'fold',              
                                    'name' => $this->l('Fold') 
                                ),
                                array(
                                    'id_option' => 'boxRandom',              
                                    'name' => $this->l('Box random') 
                                ),
                                array(
                                    'id_option' => 'boxRain',              
                                    'name' => $this->l('Box rain') 
                                ),
                                array(
                                    'id_option' => 'boxRainReverse',              
                                    'name' => $this->l('Box rain reverse') 
                                ),
                                array(
                                    'id_option' => 'boxRainGrow',              
                                    'name' => $this->l('Box rain grow') 
                                ),
                                array(
                                    'id_option' => 'boxRainGrowReverse',              
                                    'name' => $this->l('Box rain grow reverse') 
                                ),
                                array(
                                    'id_option' => 'slideInLeft',              
                                    'name' => $this->l('Slice in left') 
                                ),
                                array(
                                    'id_option' => 'slideInRight',              
                                    'name' => $this->l('Slice in right') 
                                ),
                                array(
                                    'id_option' => 'sliceDown',              
                                    'name' => $this->l('Slice down') 
                                ),
                                array(
                                    'id_option' => 'sliceDownLeft',              
                                    'name' => $this->l('Slice down left') 
                                ),
                                array(
                                    'id_option' => 'sliceUp',              
                                    'name' => $this->l('Slice up') 
                                ),
                                array(
                                    'id_option' => 'sliceUpLeft',              
                                    'name' => $this->l('Slice up left') 
                                ),
                                array(
                                    'id_option' => 'sliceUpDown',              
                                    'name' => $this->l('Slice up down') 
                                ),
                                array(
                                    'id_option' => 'sliceUpDownLeft',              
                                    'name' => $this->l('Slice up down left') 
                                )
                            ),
                			'id' => 'id_option',
                			'name' => 'name'
               		     )
                    ),
                    array(
						'type' => 'switch',
						'label' => $this->l('Use caption background'),
						'name' => 'button_type',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						),
					),                
                    array(
						'type' => 'switch',
						'label' => $this->l('Enabled'),
						'name' => 'active_slide',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						),
					),
				),                
                
                
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_slide');
			$fields_form['form']['images'] = $slide->image;

			$has_picture = true;

			foreach (Language::getLanguages(false) as $lang)
				if (!isset($slide->image[$lang['id_lang']]))
					$has_picture &= false;

			if ($has_picture)
				$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitSlide';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
			'image_baseurl' => $this->imgPath,
            'link' => $this->context->link
		);

		$helper->override_folder = '/';

		$languages = Language::getLanguages(false);

		if (count($languages) > 1)
			return $this->getMultiLanguageInfoMsg().$helper->generateForm(array($fields_form));
		else
			return $helper->generateForm(array($fields_form));
	}

	public function renderForm()
	{
	    $isAutoplay = Tools::isSubmit('submitSlider') ? Tools::getValue('YBCNIVO_LOOP') : Configuration::get('YBCNIVO_LOOP');
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Maximum image width'),
						'name' => 'YBCNIVO_WIDTH',
                        'required' => true,
						'suffix' => 'pixels  / percent',
                        'desc' => $this->l('Eg: 1000px, 100%')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Maximum image height'),
						'name' => 'YBCNIVO_HEIGHT',
                        'required' => true,
						'suffix' => 'pixels / percent',
                        'desc' => $this->l('Eg: 300px, 40%')
					),
					array(
						'type' => 'text',
						'label' => $this->l('Pause'),
						'name' => 'YBCNIVO_PAUSE',
						'suffix' => 'milliseconds',
                        'required' => true,
						'desc' => $this->l('The delay between two slides.')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Starting slide'),
						'name' => 'YBCNIVO_START_SLIDE',
                        'required' => true,
						'desc' => $this->l('Lowest valule is 1, highest value is the number of slides')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption frame width'),
						'name' => 'YBCNIVO_FRAME_WIDTH',
                        'suffix' => 'pixels / percent',
                        'required' => true,
						'desc' => $this->l('Eg: 1000px, 100%')
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Caption delay'),
						'name' => 'YBCNIVO_CAPTION_SPEED',
                        'suffix' => 'milliseconds',
                        'required' => true,
						'desc' => $this->l('Delay time between 2 captions')
					),
                    array(
						'type' => 'color',
						'label' => $this->l('Next/prev button color'),
						'name' => 'YBCNIVO_COLOR',
                        'required' => true,
                    ),
                    array(
						'type' => 'switch',
						'label' => $this->l('Hide captions on mobile'),
						'name' => 'YBCNIVO_HIDE_CAPTION',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Auto play'),
						'name' => 'YBCNIVO_LOOP',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Speed'),
                        'name' => 'YBCNIVO_SPEED',
                        'form_group_class' => 'autoplay-slider-item'.(!$isAutoplay ? ' hide' : ''),
                        'suffix' => 'milliseconds',
                        'required' => true,
                        'desc' => $this->l('The duration of the transition between two slides.')
                    ),
					array(
						'type' => 'switch',
						'label' => $this->l('Pause on hover'),
						'name' => 'YBCNIVO_PAUSE_ON_HOVER',
                        'form_group_class' => 'autoplay-slider-item'.(!$isAutoplay ? ' hide' : ''),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show control buttons'),
						'name' => 'YBCNIVO_SHOW_CONTROL',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Show next/prev buttons'),
						'name' => 'YBCNIVO_SHOW_PREV_NEXT',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
        $helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitSlider';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.(Tools::getValue('show_setting') ? '&show_setting=true' : '');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'image_baseurl' =>$this->imgPath,
            'link' => $this->context->link
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		return array(
			'YBCNIVO_WIDTH' => Tools::isSubmit('submitSlider') ? Tools::getValue('YBCNIVO_WIDTH') : Configuration::get('YBCNIVO_WIDTH'),
            'YBCNIVO_HEIGHT' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_HEIGHT') : Configuration::get('YBCNIVO_HEIGHT'),
			'YBCNIVO_SPEED' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_SPEED') : Configuration::get('YBCNIVO_SPEED'),
			'YBCNIVO_PAUSE' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_PAUSE') : Configuration::get('YBCNIVO_PAUSE'),
			'YBCNIVO_LOOP' => Tools::isSubmit('submitSlider') ?   Tools::getValue('YBCNIVO_LOOP') : Configuration::get('YBCNIVO_LOOP'),
            'YBCNIVO_START_SLIDE' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_START_SLIDE') : Configuration::get('YBCNIVO_START_SLIDE'),
            'YBCNIVO_PAUSE_ON_HOVER' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_PAUSE_ON_HOVER') : Configuration::get('YBCNIVO_PAUSE_ON_HOVER'),
            'YBCNIVO_SHOW_CONTROL' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_SHOW_CONTROL') : Configuration::get('YBCNIVO_SHOW_CONTROL'),
            'YBCNIVO_SHOW_PREV_NEXT' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_SHOW_PREV_NEXT') : Configuration::get('YBCNIVO_SHOW_PREV_NEXT'),
            'YBCNIVO_CAPTION_SPEED' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_CAPTION_SPEED') : Configuration::get('YBCNIVO_CAPTION_SPEED'),
            'YBCNIVO_COLOR' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_COLOR') : Configuration::get('YBCNIVO_COLOR'),
            'YBCNIVO_HIDE_CAPTION' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_HIDE_CAPTION') : Configuration::get('YBCNIVO_HIDE_CAPTION'),
            'YBCNIVO_FRAME_WIDTH' =>  Tools::isSubmit('submitSlider') ?  Tools::getValue('YBCNIVO_FRAME_WIDTH') : Configuration::get('YBCNIVO_FRAME_WIDTH'),
		);
	}

	public function getAddFieldsValues()
	{
		$fields = array();

		if (Tools::isSubmit('id_slide') && $this->slideExists((int)Tools::getValue('id_slide')))
		{
			$slide = new YBCNIVOSLIDE((int)Tools::getValue('id_slide'));
			$fields['id_slide'] = (int)Tools::getValue('id_slide', $slide->id);
		}
		else
        {
            $slide = new YBCNIVOSLIDE();
        }
        $fields['button_type'] = Tools::getValue('button_type', $slide->button_type);
		$fields['slide_effect'] = Tools::getValue('slide_effect', $slide->slide_effect);	
        $fields['caption_top'] = Tools::getValue('caption_top', $slide->caption_top ? $slide->caption_top : '0');
        $fields['caption_left'] = Tools::getValue('caption_left', $slide->caption_left ? $slide->caption_left : '0');
        $fields['caption_right'] = Tools::getValue('caption_right', $slide->caption_right ? $slide->caption_right : '0');
        $fields['caption_width'] = Tools::getValue('caption_width', $slide->caption_width);
        $fields['caption_position'] = Tools::getValue('caption_position', $slide->caption_position);
        $fields['caption_animate'] = Tools::getValue('caption_animate', $slide->caption_animate);
        $fields['caption_text_direction'] = Tools::getValue('caption_text_direction', $slide->caption_text_direction);
        $fields['color1'] = Tools::getValue('color1', $slide->color1);
        $fields['color2'] = Tools::getValue('color2', $slide->color2);
        $fields['color3'] = Tools::getValue('color3', $slide->color3);
        $fields['color4'] = Tools::getValue('color4', $slide->color4);
        $fields['color5'] = Tools::getValue('color5', $slide->color5);
        $fields['color6'] = Tools::getValue('color6', $slide->color6);
        $fields['color7'] = Tools::getValue('color7', $slide->color7);
        $fields['color8'] = Tools::getValue('color8', $slide->color8);
        $fields['color9'] = Tools::getValue('color9', $slide->color9);
        $fields['color10'] = Tools::getValue('color10', $slide->color10);
        $fields['opacity'] = Tools::getValue('opacity', $slide->opacity);
		$fields['active_slide'] = Tools::getValue('active_slide', $slide->active);
        
		$fields['has_picture'] = true;

		$languages = Language::getLanguages(false);
        
        /**
         *  Default
         */
        
        if(!Tools::isSubmit('submitSlide') && !Tools::isSubmit('id_slide'))
        {
            $fields['slide_effect'] = $this->default_slide_effect;
            $fields['caption_top'] = $this->default_caption_top;
            $fields['button_type'] = $this->default_button_type;
            $fields['active_slide'] = 1;
            $fields['caption_left'] = $this->default_caption_left;
            $fields['caption_right'] = $this->default_caption_right;
            $fields['caption_width'] = $this->default_caption_width;
            $fields['caption_position'] = $this->default_caption_position;
            $fields['caption_animate'] = $this->default_caption_animate;
            $fields['caption_text_direction'] = $this->default_caption_text_direction;
            $fields['color1'] = $this->default_color1;
            $fields['color2'] = $this->default_color2;
            $fields['color3'] = $this->default_color3;
            $fields['color4'] = $this->default_color4;
            $fields['color5'] = $this->default_color5;
            $fields['color6'] = $this->default_color6;
            $fields['color7'] = $this->default_color7;
            $fields['color8'] = $this->default_color8;
            $fields['color9'] = $this->default_color9;
            $fields['color10'] = $this->default_color10;
            $fields['opacity'] = $this->default_opacity;
        }
        
		foreach ($languages as $lang)
		{
			$fields['image'][$lang['id_lang']] = Tools::getValue('image_'.(int)$lang['id_lang']);
			$fields['title'][$lang['id_lang']] = Tools::getValue('title_'.(int)$lang['id_lang'], $slide->title[$lang['id_lang']]);
			$fields['url'][$lang['id_lang']] = Tools::getValue('url_'.(int)$lang['id_lang'], $slide->url[$lang['id_lang']]);
			$fields['legend'][$lang['id_lang']] = Tools::getValue('legend_'.(int)$lang['id_lang'], $slide->legend[$lang['id_lang']]);
            $fields['legend2'][$lang['id_lang']] = Tools::getValue('legend2_'.(int)$lang['id_lang'], $slide->legend2[$lang['id_lang']]);            
			$fields['description'][$lang['id_lang']] = Tools::getValue('description_'.(int)$lang['id_lang'], $slide->description[$lang['id_lang']]);
		    $fields['button_text'][$lang['id_lang']] = Tools::getValue('button_text_'.(int)$lang['id_lang'], $slide->button_text[$lang['id_lang']]);
        }

		return $fields;
	}

	private function getMultiLanguageInfoMsg()
	{
		return '<'.'p'.' class="alert alert-warning">'.
					$this->l('Since multiple languages are activated on your shop, please mind to upload your image for each one of them').
				'<'.'/'.'p'.'>';
	}

	private function getWarningMultishopHtml()
	{
		if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL)
			return '<'.'p'.' class="alert alert-warning">'.
						$this->l('You cannot manage slides items from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit').
					'<'.'/'.'p'.'>';
		else
			return '';
	}

	private function getShopContextError($shop_contextualized_name, $mode)
	{
		if ($mode == 'edit')
			return '<'.'p class="alert alert-danger"'.'>'.
							$this->l(sprintf('You can only edit this slide from the shop context: %s', $shop_contextualized_name)).
					'<'.'/p'.'>';
		else
			return '<'.'p class="alert alert-danger"'.'>'.
							$this->l(sprintf('You cannot add slides from a "All Shops" or a "Group Shop" context')).
					'<'.'/p'.'>';
	}


	private function getCurrentShopInfoMsg()
	{
		$shop_info = null;

		if (Shop::isFeatureActive())
		{
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
				$shop_info = $this->l(sprintf('The modifications will be applied to shop: %s', $this->context->shop->name));
			else if (Shop::getContext() == Shop::CONTEXT_GROUP)
				$shop_info = $this->l(sprintf('The modifications will be applied to this group: %s', Shop::getContextShopGroup()->name));
			else
				$shop_info = $this->l('The modifications will be applied to all shops and shop groups');

			return '<'.'d'.'i'.'v class="alert alert-info"'.'>'.
						$shop_info.
					'<'.'/'.'d'.'i'.'v'.'>';
		}
		else
			return '';
	}
    public function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);
       if(Tools::strlen($hex) != 6 && Tools::strlen($hex)!=3)
          return false;
       if(Tools::strlen($hex) == 3) {
          $r = hexdec(Tools::substr($hex,0,1).Tools::substr($hex,0,1));
          $g = hexdec(Tools::substr($hex,1,1).Tools::substr($hex,1,1));
          $b = hexdec(Tools::substr($hex,2,1).Tools::substr($hex,2,1));
       } else {
          $r = hexdec(Tools::substr($hex,0,2));
          $g = hexdec(Tools::substr($hex,2,2));
          $b = hexdec(Tools::substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);       
       return $rgb; // returns an array with the rgb values
    }
    public function rgbaBg($hex, $opacity)
    {
        if($opacity == 1)
            return $hex;
        $rgb = $this->hex2rgb($hex);
        if($rgb) 
            return 'rgba('.implode(',',$rgb).','.$opacity.')';
        return $hex;
    }
    public function renderCss()
    {
        $slides = $this->getSlides(true);
        $css = '<'.'style'.'>';
        $buttonColor = Configuration::get('YBCNIVO_COLOR');
        if($buttonColor)
            $css .= '.theme-default a.nivo-prevNav:before,.theme-default a.nivo-nextNav:before,.theme-default .nivo-controlNav .nivo-control.active::before{color: '.$buttonColor.';} ';
        if($slides)
        {
            foreach($slides as $slide)
            {
                $css .= $slide['color1'] ? '.caption-id-'.$slide['id_slide'].' .caption2 span{color: '.$slide['color1'].';} ' : '';
                $css .= $slide['color2'] ? '.caption-id-'.$slide['id_slide'].' .caption3 span{color: '.$slide['color2'].';} ' : '';
                $css .= $slide['color5'] ? '.caption-id-'.$slide['id_slide'].' .ybc_button_slider a{color: '.$slide['color5'].';} ' : '';
                $css .= $slide['color4'] ? '.caption-id-'.$slide['id_slide'].' .caption1 span{color: '.$slide['color4'].';} ' : '';
                $css .= $slide['color3'] ? '.caption-id-'.$slide['id_slide'].' .ybc_button_slider a{background: '.$slide['color3'].';} ' : '';
                $css .= $slide['color10'] ? '.caption-id-'.$slide['id_slide'].' .ybc_button_slider a:hover{background: '.$slide['color10'].';} ' : '';
                if($slide['button_type'] == 1)
                {
                    $opacity = $slide['opacity'];
                    $css .= $slide['color6'] ? '.caption-id-'.$slide['id_slide'].' .caption1{background: '.$this->rgbaBg($slide['color6'],$opacity).';} ' : '';
                    $css .= $slide['color7'] ? '.caption-id-'.$slide['id_slide'].' .caption2{background: '.$this->rgbaBg($slide['color7'],$opacity).';} ' : '';
                    $css .= $slide['color8'] ? '.caption-id-'.$slide['id_slide'].' .caption3{background: '.$this->rgbaBg($slide['color8'],$opacity).';} ' : '';
                    $css .= $slide['color9'] ? '.caption-id-'.$slide['id_slide'].' .caption4{background: '.$this->rgbaBg($slide['color9'],$opacity).';} ' : '';
                  
                }
            }
        }
        $css .= '<'.'/style'.'>';
        return $css;
    }

    public function createImgDir()
    {
        $cacheDir = rtrim($this->imgDir, '/');
        if(!@is_dir($cacheDir)){
            @mkdir($cacheDir, 0755, true);
            @copy(dirname(__FILE__).'/index.php', $cacheDir.'/index.php');
        }
        return true;
    }

    public function deleteDir($dirPath) {
        if (!@is_dir($dirPath)) {
            return true;
        }
        if (Tools::substr($dirPath, Tools::strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (@is_dir($file)) {
                self::deleteDir($file);
            } else {
                @unlink($file);
            }
        }
        @rmdir($dirPath);
        return true;
    }

    public function displayIframe()
    {
        switch($this->context->language->iso_code) {
            case 'en':
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'it':
                $url = 'https://cdn.prestahero.com/it/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'fr':
                $url = 'https://cdn.prestahero.com/fr/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'es':
                $url = 'https://cdn.prestahero.com/es/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            default:
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
        }
        $this->smarty->assign(
            array(
                'url_iframe' => $url
            )
        );
        return $this->display(__FILE__,'iframe.tpl');
    }
}